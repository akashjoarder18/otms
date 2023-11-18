<?php

namespace App\Repositories;

use App\Models\ClassAttendance;
use App\Repositories\Interfaces\ClassAttendanceRepositoryInterface;
use Exception;

class ClassAttendanceRepository implements ClassAttendanceRepositoryInterface
{

    public function checkAttendants($batchScheduleId, $attendanceId)
    {
        $today = date('Y-m-d');
        return ClassAttendance::where('training_batch_schedule_id', '=', $batchScheduleId)
            ->where('trainee_id', '=', $attendanceId)
            ->orWhere('trainer_id', '=', $attendanceId)
            ->where('attendant_date', '=', $today)
            ->first();
    }

    public function store($data)
    {
        return ClassAttendance::create($data);
    }

    public function markAsAbsent($attendances, $scheduleId)
    {
        try {
            foreach ($attendances as $value) {
                $attendance = ClassAttendance::where('training_batch_schedule_id', $scheduleId)
                    ->where('trainee_id', $value)
                    ->where('attendant_date', today())
                    ->first();

                $attendance->update([
                    'is_present' => 0,
                ]);
            }
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
