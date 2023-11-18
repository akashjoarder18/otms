<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\ClassAttendance;
use App\Models\District;
use App\Models\Division;
use App\Models\Profile;
use App\Models\Provider;
use App\Models\Training;
use App\Models\TrainingApplicant;
use App\Models\TrainingBatch;
use App\Models\TrainingTitle;
use App\Models\Upazila;
use App\Models\User;
use App\Repositories\Interfaces\DivisionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class DashboardController extends Controller
{
    public function summery()
    {
        // startDate < DATE_ADD (CURDATE(), INTERVAL duration DAY);
        try {
            $totalDisision = Division::count();
            $totalDistrict = District::count();
            $totalUpazila = Upazila::count();
            $totalBatch = TrainingBatch::count();
            $totalStudent = TrainingApplicant::where('IsSelected', 1)
                ->count();
            $totalProvider = Provider::count();
            $totalCourse = Training::count();
            $totalProdiver = Provider::count();
            $runningBatch = TrainingBatch::whereNotNull('startDate')
                ->whereRaw('date(startDate) <=  CURDATE()')
                ->whereRaw('DATE_ADD(date(startDate), INTERVAL duration DAY) >=  CURDATE()')
                ->count();
            $totalCoordinator = User::whereHas('role', function ($query) {
                $query->where('name', 'Trainer');
            })->count();
            $totalTrainer = User::whereHas('role', function ($query) {
                $query->where('name', 'Coordinator');
            })->count();
            $totalPresentToday = 0;/*ClassAttendance::whereRaw('attendant_date=CURDATE()')
                ->where('is_present', 1)
                ->count();*/


            return response()->json([
                'success' => true,
                'data' => [
                    'totalDisision' => $totalDisision,
                    'totalDistrict' => 44,
                    'totalUpazila' => 130,
                    'totalBatch' => $totalBatch,
                    'totalStudent' => $totalStudent,
                    'totalProvider' => $totalProvider,
                    'totalCourse' => $totalCourse,
                    'totalProdiver' => $totalProdiver,
                    'runningBatch' => $runningBatch,
                    'totalTrainer' => $totalTrainer,
                    'totalCoordinator' => $totalCoordinator,
                    'totalPresentToday' => $totalPresentToday,
                ],
            ]);
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function courses()
    {
        $courses = TrainingTitle::all();

        return response()->json([
            'success' => true,
            'data' => $courses,
        ]);
    }

    public function batches(Request $request)
    {
        $batches = TrainingBatch::with(['Provider', 'getTraining.title'])
            ->whereHas('getTraining.title', function ($query) use ($request) {
                if ($request->course_id != '') {
                    $query->where('id', $request->course_id);
                }
            })
            ->when($request->batch != '', function ($query) use ($request) {
                $query->where('batchCode', 'like', '%' . $request->batch . '%');
            })
            ->whereHas('trainingApplicant.getProfile', function ($query) use ($request) {
                if ($request->district_id != '') {
                    $query->where('district_code', $request->district_id);
                }
                if ($request->division_id != '') {
                    $query->where('division_code', $request->division_id);
                }
            })
            ->take(20)->get();

        return response()->json([
            'success' => true,
            'data' => $batches,
        ]);
    }
}
