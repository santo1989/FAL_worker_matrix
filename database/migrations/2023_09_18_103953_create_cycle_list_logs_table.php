<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCycleListLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycle_list_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_entry_id')->nullable();
            $table->unsignedBigInteger('worker_sewing_process_entries_id')->nullable();
            $table->unsignedBigInteger('sewing_process_list_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('worker_name')->nullable();
            $table->string('sewing_process_name')->nullable();
            $table->string('sewing_process_type')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->float('duration')->nullable();
            $table->string(
            'rejectDataStatus')->nullable();
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
        Schema::dropIfExists('cycle_list_logs');
    }
}
