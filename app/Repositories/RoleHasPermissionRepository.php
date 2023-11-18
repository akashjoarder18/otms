<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleHasPermission;
use App\Repositories\Interfaces\RoleHasPermissionRepositoryInterface;

class RoleHasPermissionRepository implements RoleHasPermissionRepositoryInterface
{

    public function store($role,$request)
    {
        RoleHasPermission::where('role_id',$role)->delete();
        //$rolePermission = new RoleHasPermission;
        $permissions = explode(',',$request);
        foreach($permissions as $value){
            $data = array();
            $data['permission_id'] = $value;
            $data['role_id'] = $role;
            RoleHasPermission::create([
                'permission_id' => $value,
                'role_id' => $role
            ]);
        }
    }
}
