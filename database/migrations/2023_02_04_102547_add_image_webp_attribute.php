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
        Schema::table('artists', function(Blueprint $table){
            $table->string('image_webp')->nullable()->after('image');
        });
        Schema::table('releases', function(Blueprint $table){
            $table->string('image_270')->nullable()->after('image');
        });
        Schema::table('school', function(Blueprint $table){
            $table->string('image_webp')->nullable()->after('image');
        });
        Schema::table('studio', function(Blueprint $table){
            $table->string('image_webp')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artists', function(Blueprint $table){
            $table->dropColumn('image_webp');
        });
        Schema::table('releases', function(Blueprint $table){
            $table->dropColumn('image_270');
        });
        Schema::table('school', function(Blueprint $table){
            $table->dropColumn('image_webp');
        });
        Schema::table('studio', function(Blueprint $table){
            $table->dropColumn('image_webp');
        });
    }
};
