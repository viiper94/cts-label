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
        Schema::table('email_channels', function (Blueprint $table) {
            $table->boolean('unsubscribe')->default(1);
        });
        Schema::table('email_queue', function (Blueprint $table) {
            $table->boolean('unsubscribe')->nullable();
            $table->string('template')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_channels', function (Blueprint $table) {
            $table->dropColumn('unsubscribe');
        });
        Schema::table('email_queue', function (Blueprint $table) {
            $table->dropColumn('unsubscribe');
            $table->dropColumn('template');
        });
    }
};
