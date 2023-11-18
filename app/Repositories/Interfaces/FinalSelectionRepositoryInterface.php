<?php

namespace App\Repositories\Interfaces;

interface FinalSelectionRepositoryInterface
{
    public function all();

    public function store($all_selected_users, $auth_id);
}
