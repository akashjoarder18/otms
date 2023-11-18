<?php

namespace App\Repositories\Interfaces;

interface TrainerEnrollRepositoryInterface
{
    public function all();
    
    public function details($id);
}
