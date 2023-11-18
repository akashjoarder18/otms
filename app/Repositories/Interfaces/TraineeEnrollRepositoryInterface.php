<?php

namespace App\Repositories\Interfaces;

interface TraineeEnrollRepositoryInterface
{
    public function all();
    
    public function details($id);
}
