<?php

namespace App\Repositories;

use App\Models\ProvidersTrainer;
use App\Repositories\Interfaces\TrainerEnrollRepositoryInterface;
use App\Traits\UtilityTrait;

class TrainerEnrollRepository implements TrainerEnrollRepositoryInterface
{
    use UtilityTrait;

    public function all()
    {
        return ProvidersTrainer::with('profile', 'trainingBatch', 'provider')->get();
    }

    public function details($id)
    {
        return ProvidersTrainer::with('profile', 'trainingBatch', 'provider')->where('id', '=', $id)->first();
    }

}
