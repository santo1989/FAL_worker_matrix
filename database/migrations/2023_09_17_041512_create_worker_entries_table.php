<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->string('division_name')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('department_name')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('designation_name')->nullable();
            $table->string('employee_name_english')->nullable();
            $table->string('id_card_no')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('present_grade')->nullable();
            $table->string('recomanded_grade')->nullable();
            $table->string('recomanded_salary')->nullable();
            $table->string('experience')->nullable();
            $table->string('salary')->nullable(); 
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->date('examination_date')->nullable();
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
        Schema::dropIfExists('worker_entries');
    }
}
