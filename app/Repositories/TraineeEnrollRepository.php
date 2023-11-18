<?php

namespace App\Repositories;

use App\Models\TrainingApplicant;
use App\Repositories\Interfaces\TraineeEnrollRepositoryInterface;
use App\Traits\UtilityTrait;

class TraineeEnrollRepository implements TraineeEnrollRepositoryInterface
{
    use UtilityTrait;

    public function all()
    {
        return TrainingApplicant::with('profile', 'trainingBatch', 'trainingTitle')->where('IsTrainee',1)->get();
    }

    public function details($id)
    {
        return TrainingApplicant::with('profile', 'trainingBatch', 'trainingTitle')->where('id', '=', $id)->first();
    }

}
