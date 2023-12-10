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
        Schema::create('artist_cvs', function (Blueprint $table) {
            $table->id();
            $table->string('main_contact_name')->nullable();
            $table->string('main_contact_phone')->nullable();
            $table->string('main_contact_email')->nullable();
            $table->text('tracks_to_sign')->nullable();
            $table->string('doc')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_cvs');
    }
};
