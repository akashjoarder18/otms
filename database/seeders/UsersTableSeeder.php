<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
        public function run()
        {
            
        // Seed 10 users for testing
        for ($i = 1; $i <= 10; $i++) {
           
            $userData = [
                'fname' => 'User' . $i,
                'lname' => 'Lastname' . $i,
                'username' => 'username' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('12345678'),
                'role_id' => 8,
                'phone_number' => '0123456789',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('users')->insert($userData);

           
            }
        }
}
