<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSewingProcessListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sewing_process_lists', function (Blueprint $table) {
            $table->id();
            $table->string('process_type')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('process_name')->nullable();
            $table->string('standard_capacity')->nullable();
            $table->string('standard_time_sec')->nullable();
            $table->string('smv')->nullable();
            $table->string('dataEntryBy')->nullable();
            $table->dateTime('dataEntryDate')->nullable();
            $table->string('dataEditBy')->nullable();
            $table->dateTime('dataEditDate')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('sewing_process_lists');
    }
}
