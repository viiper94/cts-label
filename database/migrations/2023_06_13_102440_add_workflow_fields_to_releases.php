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
            $table->boolean('uploaded_on_beatport')->default(1);
            $table->boolean('uploaded_on_believe')->default(1);
            $table->boolean('uploaded_on_juno')->default(1);
            $table->boolean('uploaded_on_google_drive')->default(1);
            $table->boolean('promo_upload')->default(1);
            $table->boolean('uploaded_on_zip_dj')->default(1);
            $table->boolean('uploaded_on_music_worx')->default(1);
            $table->boolean('uploaded_on_release_promo')->default(1);
            $table->boolean('label_copy_uploaded')->default(1);
            $table->boolean('is_emailing_done')->default(0);
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->boolean('uploaded_on_beatport')->default(0)->change();
            $table->boolean('uploaded_on_believe')->default(0)->change();
            $table->boolean('uploaded_on_juno')->default(0)->change();
            $table->boolean('uploaded_on_google_drive')->default(0)->change();
            $table->boolean('promo_upload')->default(0)->change();
            $table->boolean('uploaded_on_zip_dj')->default(0)->change();
            $table->boolean('uploaded_on_music_worx')->default(0)->change();
            $table->boolean('uploaded_on_release_promo')->default(0)->change();
            $table->boolean('label_copy_uploaded')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('releases', function (Blueprint $table) {
            $table->dropColumn('uploaded_on_beatport');
            $table->dropColumn('uploaded_on_believe');
            $table->dropColumn('uploaded_on_juno');
            $table->dropColumn('uploaded_on_google_drive');
            $table->dropColumn('promo_upload');
            $table->dropColumn('uploaded_on_zip_dj');
            $table->dropColumn('uploaded_on_music_worx');
            $table->dropColumn('uploaded_on_release_promo');
            $table->dropColumn('label_copy_uploaded');
            $table->dropColumn('is_emailing_done');
        });
    }
};
