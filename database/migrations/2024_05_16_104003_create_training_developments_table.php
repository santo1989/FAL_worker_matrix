<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingDevelopmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_developments', function (Blueprint $table) {
            $table->id(); 
            $table->date('training_date')->nullable();
            $table->unsignedBigInteger('worker_entry_id')->nullable();
            $table->date('examination_date')->nullable();
            $table->text('training_name')->nullable();
            $table->string('id_card_no')->nullable();
            $table->string('training_duration')->nullable();
            $table->string('dataEntryBy')->nullable();
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
        Schema::dropIfExists('training_developments');
    }
}
