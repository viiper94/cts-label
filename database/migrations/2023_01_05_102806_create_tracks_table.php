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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mix_name')->nullable();
            $table->text('artists');
            $table->text('remixers')->nullable();
            $table->string('composer')->nullable();
            $table->string('isrc')->nullable();
            $table->integer('bpm')->nullable();
            $table->string('genre')->nullable();
            $table->integer('length')->nullable();
            $table->integer('beatport_id')->nullable();
            $table->integer('beatport_release_id')->nullable();
            $table->text('beatport_wave')->nullable();
            $table->text('beatport_sample')->nullable();
            $table->integer('beatport_sample_start')->nullable();
            $table->integer('beatport_sample_end')->nullable();
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
        Schema::dropIfExists('tracks');
    }
};
