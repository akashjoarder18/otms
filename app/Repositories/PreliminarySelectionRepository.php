<?php

namespace App\Repositories;

use App\Models\PrelimarySelection;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\Interfaces\PreliminarySelectionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class PreliminarySelectionRepository implements PreliminarySelectionRepositoryInterface
{
    public function all()
    {
        $all_preliminary_selected = PrelimarySelection::with('user', 'user.role', 'user.userDetail', 'user.userDetail.district', 'user.userDetail.upazila', 'category', 'subCategory')
            ->get();

        return $all_preliminary_selected;
    }

    public function store($all_selected_users, $auth_id)
    {
        try {
            foreach ($all_selected_users as $value) {
                $user = User::find($value);
                $userDetails = UserDetail::where('user_id', $value)->first();

                if (!$userDetails) {
                    throw new Exception('UserDetail not found for user id: ' . $value);
                }

                $already_selected = PrelimarySelection::where('user_id', $value)->first();

                if ($already_selected) {
                    throw new Exception('User already exits: ' . $user->fname . " " . $user->lname);
                }

                $data = [
                    'user_id' => $value,
                    'category_id' => $userDetails->category_id,
                    'sub_category_id' => $userDetails->sub_category_id,
                    'is_selected' => 1,
                    'selection_date' => now(),
                    'created_user_id' => $auth_id,
                ];

                PrelimarySelection::create($data);
            }
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
