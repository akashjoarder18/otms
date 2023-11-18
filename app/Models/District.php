<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $table = "geodistricts";
    protected $guarded = [];


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function division()
    {
        return $this->belongsTo(Division::class,'ParentCode','Code');
    }

    public function userType()
    {
        return $this->hasMany(UserType::class);
    }

    public function userDetail()
    {
        return $this->hasMany(UserDetail::class);
    }
}
