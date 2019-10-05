<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sort_id');
            $table->string('title');
            $table->string('release_number')->nullable();
            $table->date('release_date')->nullable();
            $table->string('image')->nullable();
            $table->string('beatport')->nullable();
            $table->string('youtube')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_ua')->nullable();
            $table->text('tracklist')->nullable();
            $table->boolean('visible')->default(1);
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
        Schema::dropIfExists('releases');
    }
}