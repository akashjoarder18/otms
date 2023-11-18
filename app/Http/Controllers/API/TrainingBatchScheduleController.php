<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingBatchScheduleRequest;
use App\Models\BatchScheduleDetail;
use App\Models\ClassAttendance;
use App\Models\TrainingBatchSchedule;
use App\Repositories\BatchScheduleDetailRepository;
use App\Repositories\ClassAttendanceRepository;
use App\Repositories\TrainingBatchScheduleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingBatchScheduleController extends Controller
{
    /*
     * Handle Bridge Between Database and Business layer
     */
    private $trainingBatchScheduleRepository, $batchScheduleDetailRepository, $classAttendanceRepository;
    public function __construct(
        TrainingBatchScheduleRepository $trainingBatchScheduleRepository,
        ClassAttendanceRepository $classAttendanceRepository,
        BatchScheduleDetailRepository $batchScheduleDetailRepository,
    ) {
        $this->trainingBatchScheduleRepository = $trainingBatchScheduleRepository;
        $this->classAttendanceRepository = $classAttendanceRepository;
        $this->batchScheduleDetailRepository = $batchScheduleDetailRepository;
    }

    /*
     * Store Training Batch Schedule
     */
    public function store(TrainingBatchScheduleRequest $request)
    {
        try {
            $data = $request->all();
            $batch_schedule = $this->trainingBatchScheduleRepository->store($data);

            // make Batch Schedule Details
            $detail_data = [
                'batch_schedule_id' => $batch_schedule->id,
                'start_time' => $batch_schedule->class_time,
                'training_batch_id' => $batch_schedule->training_batch_id,
                'provider_id' => $batch_schedule->provider_id,
                'total_class' => $batch_schedule->class_duration,
                'class_days' => $batch_schedule->class_days,
            ];


            $this->batchScheduleDetailRepository->store($detail_data);


            return response()->json([
                'success' => true,
                'error' => false,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * show schedule/get schedule data
     */
    public function myClass($classScheduleId)
    {
        try {
            $classSchedule = TrainingBatchSchedule::find($classScheduleId);
            $classScheduleDetails = BatchScheduleDetail::where('batch_schedule_id', $classScheduleId)
                ->where('date', today())
                ->first();

            $user = Auth::user();
            $user_id = $user->id;
            $user_role = $user->role->name;
            $data = $classScheduleDetails;
            $classStatus = '';
            if ($classScheduleDetails) {
                $today = date('Y-m-d');

                $classStarted = $classScheduleDetails->isClassStarted();

                $classExpired = $classScheduleDetails->isClassExpired();

                if (!$classStarted) {
                    $classStatus = 0;
                } elseif ($classStarted && !$classExpired) {
                    $classStatus = 1;

                    $attendance = array();
                    $attendance['training_batch_schedule_id'] = $classSchedule->id;
                    if ($user_role == 'Trainee') {
                        $attendance['trainee_id'] = $user_id;
                    }
                    if ($user_role == 'Trainer') {
                        $attendance['trainer_id'] = $user_id;
                    }
                    $attendance['is_present'] = 1;
                    $attendance['attendant_date'] = $today;

                    $myAttendant = $this->classAttendanceRepository->checkAttendants($classSchedule->id, $user_id);

                    if (!$myAttendant) {
                        $myAttendant = $this->classAttendanceRepository->store($attendance);
                    }
                } elseif ($classExpired) {
                    $classStatus = -1;
                }
            }

            return response()->json([
                'success' => true,
                'error' => false,
                'data' => $classScheduleId,
                'classStatus' => $classStatus,
                'usrRole' => $user_role,
                'message' => 'Your attendance counted automatically',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * check attendance of each batch
     */
    public function checkAttendance($ScheduleId)
    {
        try {
            $classSchedule = TrainingBatchSchedule::with('trainingBatch')
                ->where('id', $ScheduleId)->first();
            $user = Auth::user();
            $user_id = $user->id;
            $user_role = $user->role->name;
            $data['schedule'] = $classSchedule;
            $attendance = ClassAttendance::with('user')
                ->where('training_batch_schedule_id', $ScheduleId)
                ->where('attendant_date', today())
                ->where('is_present', 1)
                ->whereNotNull('trainee_id')
                ->get();
            $data['attendance'] = $attendance;
            $classStatus = '';
            if ($classSchedule) {
            }

            return response()->json([
                'success' => true,
                'error' => false,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * counter attendance mark as absent
     */
    public function counterAttendance(Request $request, $ScheduleId)
    {
        try {
            $selected_attendances = $request->input('selectedAttendIds');

            $result = $this->classAttendanceRepository->markAsAbsent($selected_attendances, $ScheduleId);

            return response([
                'success' => true,
                'error' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
