<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldMatrixDataStatusToWorkerEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_entries', function (Blueprint $table) {
            $table->string('old_matrix_Data_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worker_entries', function (Blueprint $table) {
            $table->dropColumn('old_matrix_Data_status');
        });
    }
}
