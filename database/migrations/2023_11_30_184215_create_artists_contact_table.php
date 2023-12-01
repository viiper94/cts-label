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
        Schema::create('artist_contact', function (Blueprint $table) {
            $table->id();
            $table->integer('artist_cv_id');
            $table->string('surname');
            $table->string('first_name');
            $table->string('artist_name');
            $table->string('publisher');
            $table->string('date_of_birth');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
            $table->string('phone');
            $table->string('email');
            $table->string('bank');
            $table->string('place_of_bank');
            $table->string('account_holder');
            $table->string('account_number');
            $table->string('passport_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_contact');
    }
};
