<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'Programmer',
            'AP',
            'PUser',
            'DUser',
            'PIUOfficer',
            'Member',
            'Trainee',
            'Trainer',
            'Inspector',
            'Provider',
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
