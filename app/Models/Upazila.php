<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;
    protected $table = "geoupazilas";
    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class, 'ParentCode', 'Code');
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
