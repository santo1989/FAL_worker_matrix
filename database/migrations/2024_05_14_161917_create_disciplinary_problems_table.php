<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinaryProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinary_problems', function (Blueprint $table) {
            $table->id();
            $table->date('disciplinary_problem_date')->nullable();
            $table->unsignedBigInteger('worker_entry_id')->nullable();
            $table->date('examination_date')->nullable();
            $table->boolean('disciplinary_problem_status')->default(0); // 0 = No, 1 = Yes
            $table->text('disciplinary_problem_description')->nullable();
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
        Schema::dropIfExists('disciplinary_problems');
    }
}
