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
        Schema::create('email_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name')->nullable();
            $table->string('email');
            $table->text('company')->nullable();
            $table->text('position')->nullable();
            $table->text('additional')->nullable();
            $table->string('lang')->nullable()->default('en');
            $table->text('email_channels')->nullable();
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
        Schema::dropIfExists('email_contacts');
    }
};
