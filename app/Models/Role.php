<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "tms_roles";
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'tms_role_has_permissions', 'role_id', 'permission_id');
    }

    public function userType()
    {
        return $this->hasMany(UserType::class);
    }

  
}
