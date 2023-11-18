<?php

namespace App\Repositories\Interfaces;

interface UserlogRepositoryInterface
{
    public function findByUserIdWithLimit($id, $take);
}
