<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('releases', function(Blueprint $table){
            $table->boolean('tracklist_show_artist')->default(1);
            $table->boolean('tracklist_show_title')->default(1);
            $table->boolean('tracklist_show_mix')->default(1);
            $table->boolean('tracklist_show_custom')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('releases', function(Blueprint $table){
            $table->dropColumn('tracklist_show_artist');
            $table->dropColumn('tracklist_show_title');
            $table->dropColumn('tracklist_show_mix');
            $table->dropColumn('tracklist_show_custom');
        });
    }

};
