<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFeedbackResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback_results', function (Blueprint $table) {
            $table->renameColumn('feedback_rid', 'feedback_id');
            $table->text('best_track')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback_results', function (Blueprint $table) {
            $table->renameColumn('feedback_id', 'feedback_rid');
            $table->text('best_track')->change();
        });
    }
}
