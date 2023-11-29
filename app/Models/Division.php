<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;
    protected $table = "geodivisions";
    protected $guarded = [];


    public function districts()
    {
        return $this->hasMany(District::class, 'ParentCode', 'Code');
    }

}