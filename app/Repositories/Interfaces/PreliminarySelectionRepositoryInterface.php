<?php

namespace App\Repositories\Interfaces;

interface PreliminarySelectionRepositoryInterface
{
    public function all();
    
    public function store($all_selected_users, $auth_id);
}
