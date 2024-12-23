<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerSewingProcessEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_sewing_process_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_entry_id')->nullable();
            $table->unsignedBigInteger('sewing_process_list_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('worker_name')->nullable();
            $table->string('sewing_process_name')->nullable();
            $table->string('sewing_process_type')->nullable();
            $table->float('smv')->nullable();
            $table->float('target')->nullable();
            $table->float('sewing_process_avg_cycles')->nullable();
            $table->float('capacity')->nullable();
            $table->float('self_production')->nullable();
            $table->float('achive_production')->nullable();
            $table->float('efficiency')->nullable();
            $table->string('necessity_of_helper')->nullable();
            $table->string('perception_about_size')->nullable();
            $table->date('examination_date')->nullable();
            $table->string('dataEntryBy')->nullable();
            $table->dateTime('dataEntryDate')->nullable();
            $table->string('dataEditBy')->nullable();
            $table->dateTime('dataEditDate')->nullable();
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
        Schema::dropIfExists('worker_sewing_process_entries');
    }
}
