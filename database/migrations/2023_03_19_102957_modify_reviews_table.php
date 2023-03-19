<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function(Blueprint $table){
            $table->dropColumn('track');
            $table->dropColumn('data');
            $table->integer('track_id');
            $table->string('author')->nullable();
            $table->string('location')->nullable();
            $table->text('review')->nullable();
            $table->integer('score')->nullable();
            $table->string('source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function(Blueprint $table){
            $table->string('track');
            $table->longText('data');
            $table->dropColumn('track_id');
            $table->dropColumn('author');
            $table->dropColumn('location');
            $table->dropColumn('review');
            $table->dropColumn('score');
            $table->dropColumn('source');
        });
    }
};
