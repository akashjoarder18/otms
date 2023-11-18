<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('upazila_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->enum('gender',["M","F"])->default("F");            
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->string('father_name',60);
            $table->string('mother_name',60);
            $table->string('nid');
            $table->string('b_certificate')->nullable();
            $table->string('image_url')->nullable();
            $table->string('hsc_certificate')->nullable();
            $table->string('ssc_certificate')->nullable();
            $table->enum('employment_status',["Employed","Self Employed","In Education","House Wife","Unemployed","Others"])->default("In Education");  
            $table->enum('financial_status',["Highly Solvent","Solvent","Mid Level Solvent","Not Solvent"])->default("Not Solvent");  
            $table->boolean('past_training')->default(0);
            $table->string('past_course_name')->nullable();
            $table->string('past_course_duration')->nullable();
            $table->unsignedBigInteger('past_provider_id')->nullable();
            $table->string('signature')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('bkash_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
};
