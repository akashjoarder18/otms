<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvidersBatchCoordinator extends Model
{
    use HasFactory;

    protected $table = "tms_providers_batch_coordinators";
    protected $guarded = [];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'id', 'ProfileId');
    }
}
