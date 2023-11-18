<?php

namespace App\Repositories\Interfaces;

interface RoleHasPermissionRepositoryInterface
{

    public function store($role,$request);
}
