<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BatchScheduleDetail;
use App\Models\ClassAttendance;
use App\Models\District;
use App\Models\Division;
use App\Models\Provider;
use App\Models\ProvidersTrainer;
use App\Models\TrainerProfile;
use App\Models\Training;
use App\Models\TrainingApplicant;
use App\Models\TrainingBatch;
use App\Models\TrainingTitle;
use App\Models\Upazila;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Traits\UtilityTrait;

class DashboardController extends Controller
{
    use UtilityTrait;
    public function summery()
    {
        // startDate < DATE_ADD (CURDATE(), INTERVAL duration DAY);
        try {
            $user = auth()->user();
            $userType = $this->authUser($user->email);
            

            $provider_id = $userType->provider_id;

            $totalDisision = Division::count();
            $totalDistrict = District::count();
            $totalUpazila = Upazila::count();

            if ($provider_id) {


                $totalBatchData = TrainingBatch::where('provider_id', $provider_id)->whereNotNull('startDate')->get();
 
               
                $runningBatch = TrainingBatch::where('provider_id', $provider_id)->whereNotNull('startDate')
                    ->whereRaw('date(startDate) <=  CURDATE()')
                    ->whereRaw('DATE_ADD(date(startDate), INTERVAL duration DAY) >=  CURDATE()')
                    ->count();
                $totalBatch = count($totalBatchData);
                $totalTrainer = ProvidersTrainer::where('provider_id', $provider_id)->count();
                $totalStudent = 0;
                if (count($totalBatchData) > 0) {
                    
                    foreach ($totalBatchData as $trainee) {
                      
                        $student = TrainingApplicant::where('BatchId',$trainee->id)->where('IsTrainee', 1)->first();
                        if($student){
                            $totalStudent = $totalStudent+1;
                        }
                    }
                }
            } else {
                $totalBatch = TrainingBatch::count();
                $runningBatch = TrainingBatch::whereNotNull('startDate')
                    ->whereRaw('date(startDate) <=  CURDATE()')
                    ->whereRaw('DATE_ADD(date(startDate), INTERVAL duration DAY) >=  CURDATE()')
                    ->count();
                $totalTrainer = TrainerProfile::count();
                $totalStudent = TrainingApplicant::where('IsTrainee', 1)
                    ->count();
                
            }

            $totalProvider = Provider::count();
            $totalCourse = Training::count();
            //$totalProdiver = Provider::count();

            $totalCoordinator = 0;

            
            $totalPresentToday = BatchScheduleDetail::whereRaw('date=CURDATE()')->get();
            $totalPresent = 0;
            if (count($totalPresentToday) > 0) {
                foreach ($totalPresentToday as $row) {
                    $present = ClassAttendance::where('batch_schedule_detail_id', $row['id'])->where('is_present', 1)->get();
                    if ($present) {
                        $totalPresent = count($present) + $totalPresent;
                    }
                }
            }
            $todaysTotalPresent = $totalPresent;
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
                    'runningBatch' => $runningBatch,
                    'totalTrainer' => $totalTrainer,
                    'totalCoordinator' => $totalCoordinator,
                    'totalPresentToday' => $todaysTotalPresent,
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
