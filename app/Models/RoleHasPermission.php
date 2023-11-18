<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;

    protected $table = "tms_role_has_permissions";
    protected $guarded = [];

    public $timestamps = false;
}
