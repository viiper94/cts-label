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
        Schema::table('email_contacts', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('company_foa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_contacts', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('website');
            $table->dropColumn('country');
            $table->dropColumn('company_foa');
        });
    }
};
