<?php

namespace Database\Seeders;

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

        for ($i = 0; $i < 50; $i++) {
            Inspection::create([
                'batche_id' => 1,
                'user_id' => 1,
                'classnum' => 1,
                'labsize' => 1,
                'electricity' => 1,
                'internet' => 1,
                'labbill' => 1,
                'labattandance' => 1,
                'computer' => 1,
                'router' => 1,
                'projectortv' => 1,
                'usinglaptop' => 1,
                'labsecurity' => 1,
                'labreagister' => 1,
                'classreagulrity' => 1,
                'teacattituted' => 1,
                'teaclabatten' => 1,
                'upojelaodit' => 1,
                'upozelamonotring' => 1,
                'remark' => "remark",
            ]);
        }
    }
}