<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingApplicant extends Model
{
    use HasFactory;
    protected $table = "training_applicants";
    protected $guarded = [];


    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'ProfileId');
    }

    public function trainingBatch()
    {
        return $this->belongsTo(TrainingBatch::class, 'BatchId');
    }

    public function trainingTitle()
    {
        return $this->hasOne(TrainingTitle::class, 'id', 'TrainingTitleId');
    }

    public function getProfile()
    {
        return $this->belongsTo(Profile::class, 'ProfileId');
    }
}
