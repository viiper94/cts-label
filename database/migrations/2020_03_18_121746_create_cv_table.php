<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('status')->default(0);
            $table->string('name');
            $table->string('email');
            $table->date('birth_date');
            $table->string('dj_name')->nullable();
            $table->string('vk')->nullable();
            $table->string('facebook')->nullable();
            $table->string('soundcloud')->nullable();
            $table->string('other_social')->nullable();
            $table->string('phone_number');
            $table->text('address');
            $table->text('education');
            $table->text('job');
            $table->text('sound_engineer_skills')->nullable();
            $table->text('sound_producer_skills')->nullable();
            $table->text('dj_skills')->nullable();
            $table->text('music_genres');
            $table->text('additional_info')->nullable();
            $table->text('learned_about_ctschool');
            $table->text('what_to_learn')->nullable();
            $table->text('purpose_of_learning')->nullable();
            $table->timestamp('closed_at')->nullable();
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
        Schema::dropIfExists('cv');
    }
}
