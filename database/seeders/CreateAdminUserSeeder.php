<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserVerify;
use App\Models\Role;
use App\Models\UserType;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role =  Role::where('name', 'admin')->orWhere('name', 'Admin')->first();
        if ($role) {
            $roleId = $role->id;
        } else {
            $role = Role::create(['name' => 'Admin']);
            $roleId = $role->id;
        }
        $user = User::create([
            'fname' => 'Sayed',
            'lname' => 'Al Momin',
            'email' => 'akash@gmail.com',
            'reg_id' => mt_rand(100000, 999999),
            'role_id' => $roleId,
            'username' => 'sayed',
            'password' => \Hash::make(12345678)
        ]);

        $token = Str::random(64);
        $verifyUser = UserVerify::create([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->email_verified_at) {
                $verifyUser->user->email_verified_at = date('Y-m-d H:i:s');
                $verifyUser->user->save();
            }
        }

        UserType::create([
            "name" => "Super Admin",
            "user_id" => $user->id,
        ]);
    }
}
