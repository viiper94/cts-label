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
        Schema::table('email_queue', function (Blueprint $table) {
            $table->text('data')->nullable();
            $table->integer('feedback_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_queue', function (Blueprint $table) {
            $table->dropColumn('data');
            $table->dropColumn('feedback_id');
        });
    }
};
