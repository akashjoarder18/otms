<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Training;
use App\Models\TrainingBatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Inspection;


class InspectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inspection::truncate();

        for ($i = 0; $i < 100; $i++) {
            $randomTrainingBatchId = TrainingBatch::inRandomOrder()->select('id')->first();
            $profileId = Profile::inRandomOrder()->select('id')->first();
            Inspection::create([
                'batch_id' => $randomTrainingBatchId->id,
                'class_no' => rand(0, 1),
                'lab_size' => rand(0, 1),
                'electricity' => rand(0, 1),
                'internet' => rand(0, 1),
                'lab_bill' => rand(0, 1),
                'lab_attendance' => rand(0, 1),
                'computer' => rand(0, 1),
                'router' => rand(0, 1),
                'projector' => rand(0, 1),
                'student_laptop' => rand(0, 1),
                'lab_security' => rand(0, 1),
                'lab_register' => rand(0, 1),
                'class_regularity' => rand(0, 1),
                'trainer_attituted' => rand(0, 1),
                'trainer_tab_attendance' => rand(0, 1),
                'upazila_audit' => rand(0, 1),
                'upazila_monitoring' => rand(0, 1),
                'remark' => fake()->text(),
                'created_by' => $profileId->id,
            ]);
        }
    }
}