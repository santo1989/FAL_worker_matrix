<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMigrateWorkerListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('migrate_worker_lists', function (Blueprint $table) {
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
            $table->string('migration_reson')->nullable();
            $table->date('last_working_date')->nullable();
            $table->string('service_length')->nullable();
            $table->string('last_salary')->nullable();
            $table->string('migrate_month')->nullable();
            $table->string('data_entry_by')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('migrate_worker_lists');
    }
}
