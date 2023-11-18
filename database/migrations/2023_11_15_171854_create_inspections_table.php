<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batche_id');
            $table->foreignId('user_id');
            $table->tinyInteger('classnum');
            $table->tinyInteger('labsize');
            $table->tinyInteger('electricity');
            $table->tinyInteger('internet');
            $table->tinyInteger('labbill');
            $table->tinyInteger('labattandance');
            $table->tinyInteger('computer');
            $table->tinyInteger('router');
            $table->tinyInteger('projectortv');
            $table->tinyInteger('usinglaptop');
            $table->tinyInteger('labsecurity');
            $table->tinyInteger('labreagister');
            $table->tinyInteger('classreagulrity');
            $table->tinyInteger('teacattituted');
            $table->tinyInteger('teaclabatten');
            $table->tinyInteger('upojelaodit');
            $table->string('upozelamonotring');
            $table->string('remark');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('Updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspections');
    }
};