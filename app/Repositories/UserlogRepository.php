<?php

namespace App\Repositories;

use App\Models\Userlog;
use App\Repositories\Interfaces\UserlogRepositoryInterface;

class UserlogRepository implements UserlogRepositoryInterface
{
    public function findByUserIdWithLimit($id, $take)
    {
        return Userlog::where('userlogs.user_id', $id)
            ->orderBy('id', 'DESC')
            ->take($take)
            ->get();
    }
}
