<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = "tms_permissions";
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'tms_role_has_permissions', 'permission_id','role_id');
    }
}
