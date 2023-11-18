<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function all();

    public function userWithRole($id);

    public function store($data);

    public function update($user, $data);
}
