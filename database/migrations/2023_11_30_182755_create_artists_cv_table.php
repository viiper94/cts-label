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
            $table->string('main_contact_name');
            $table->string('main_contact_phone');
            $table->string('main_contact_email');
            $table->string('doc');
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
