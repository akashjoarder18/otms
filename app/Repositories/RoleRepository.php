<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function all()
    {
        return Role::with('permissions','userType')->get();
    }


    public function store($data,$request)
    {
        
        $role = Role::create($data);
        return $role->syncPermissions($request->get('permission'));
    }

    public function details($id)
    {
        return Role::with('permissions')->where('id', '=', $id)->first();
    }

    public function find($id)
    {

        return Role::find($id);
    }

    public function update($role, $data)
    {
        $role->name = $data['name'];
        $role->save();
    }

    public function delete($id)
    {
        return Role::find($id);
    }
}
