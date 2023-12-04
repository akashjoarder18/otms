<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingBatchSchedule extends Model
{
    use HasFactory;

    protected $table = "tms_training_batch_schedules";
    protected $guarded = [];
    public $timestamps = false;

    public function trainingBatch()
    {
        return $this->belongsTo(TrainingBatch::class);
    }
    public function scheduleDetails()
    {
        return $this->hasMany(BatchScheduleDetail::class, 'batch_schedule_id');
    }
    public function isStatus1()
    {
        return $this->hasOne(BatchScheduleDetail::class, 'batch_schedule_id')
            ->where('status', 1);
    }
    public function isStatus2()
    {
        return $this->hasOne(BatchScheduleDetail::class, 'batch_schedule_id')
            ->where('status', 2);
    }
    /**
     * class time over or not check function 
     */
    public function isClassDay()
    {
        return false;
    }
}
