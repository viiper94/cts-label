<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseToCv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cv', function (Blueprint $table) {
            $table->string('course');
            $table->text('os')->nullable();
            $table->text('equipment')->nullable();
            $table->text('music_genres')->nullable()->change();
            $table->string('document')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cv', function (Blueprint $table) {
            $table->dropColumn('course');
            $table->dropColumn('os');
            $table->dropColumn('equipment');
            $table->text('music_genres')->change();
            $table->dropColumn('document');
        });
    }
}
