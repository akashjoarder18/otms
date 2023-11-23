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
        Schema::create('tms_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id');
            $table->tinyInteger('class_no');
            $table->tinyInteger('lab_size');
            $table->tinyInteger('electricity');
            $table->tinyInteger('internet');
            $table->tinyInteger('lab_bill');
            $table->tinyInteger('lab_attendance');
            $table->tinyInteger('computer');
            $table->tinyInteger('router');
            $table->tinyInteger('projector');
            $table->tinyInteger('student_laptop');
            $table->tinyInteger('lab_security');
            $table->tinyInteger('lab_register');
            $table->tinyInteger('class_regularity');
            $table->tinyInteger('trainer_attituted');
            $table->tinyInteger('trainer_tab_attendance');
            $table->tinyInteger('upazila_audit');
            $table->tinyInteger('upazila_monitoring');
            $table->string('remark');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
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