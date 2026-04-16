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
        Schema::table('releases', function (Blueprint $table) {
            $table->string('upc')->nullable()->after('id');
            $table->string('main_artists')->nullable()->after('title');
            $table->date('non_exclusive_release_date')->nullable()->after('release_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('releases', function (Blueprint $table) {
            $table->dropColumn('upc');
            $table->dropColumn('non_exclusive_release_date');
            $table->dropColumn('main_artists');
        });
    }
};
