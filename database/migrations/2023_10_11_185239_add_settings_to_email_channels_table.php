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
        Schema::table('email_channels', function (Blueprint $table) {
            $table->string('from_name');
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->string('smtp_send_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_channels', function (Blueprint $table) {
            $table->dropColumn('from_name');
            $table->dropColumn('smtp_host');
            $table->dropColumn('smtp_port');
            $table->dropColumn('smtp_username');
            $table->dropColumn('smtp_password');
            $table->dropColumn('smtp_encryption');
            $table->dropColumn('smtp_send_rate');
        });
    }
};
