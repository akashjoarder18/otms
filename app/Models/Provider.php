<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Provider extends Model
{
    use HasFactory;

    protected $table = "development_partners";
    protected $guarded = [];

    public function userType()
    {
        return $this->hasMany(UserType::class);
    }

    public function TrainingBatches()
    {
        return $this->hasMany(TrainingBatch::class);
    }
}
