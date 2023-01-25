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
        Schema::create('feedback_tracks', function (Blueprint $table) {
            $table->id();
            $table->integer('track_id')->nullable();
            $table->integer('feedback_id')->nullable();
            $table->string('name')->nullable();
            $table->string('file_320')->nullable();
            $table->string('file_96')->nullable();
            $table->text('peaks')->nullable();
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
        Schema::dropIfExists('feedback_tracks');
    }
};
