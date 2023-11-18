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
        Schema::create('emailnotifications', function (Blueprint $table) {
            $table->id();
            $table->string('email_id');
            $table->string('subject');
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->dateTime('send_date')->nullable();
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
        Schema::dropIfExists('emailnotifications');
    }
};
