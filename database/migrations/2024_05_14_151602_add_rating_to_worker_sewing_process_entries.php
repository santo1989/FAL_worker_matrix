<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToWorkerSewingProcessEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_sewing_process_entries', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worker_sewing_process_entries', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
}
