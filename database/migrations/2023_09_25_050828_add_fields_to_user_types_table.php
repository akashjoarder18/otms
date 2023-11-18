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
        Schema::table('user_types', function (Blueprint $table) {
            $table->string('image_url')->nullable()->after('designation');
            $table->enum('gender',["M","F"])->default("M")->after('image_url'); 
            $table->text('address')->nullable()->after('gender'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_types', function (Blueprint $table) {
            $table->dropColumn('image_url');
            $table->dropColumn('gender');
            $table->dropColumn('address');
        });
    }
};
