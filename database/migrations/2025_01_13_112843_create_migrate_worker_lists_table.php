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
            // Worker Entry Data (store all worker data as JSON)
            $table->unsignedBigInteger('original_worker_entry_id');
            $table->json('worker_entry_data');

            // Related Data (store all related records as JSON)
            $table->json('sewing_process_entries_data');
            $table->json('cycle_list_logs_data');
            $table->json('training_developments_data');
            $table->json('disciplinary_problems_data');

            // Migration Information
            $table->string('id_card_no');
            $table->string('employee_name_english');
            $table->enum('migration_reason', ['resigned', 'terminated', 'retired', 'transferred', 'inactive', 'other']);
            $table->date('migration_date');
            $table->date('last_working_date');
            $table->string('service_length');
            $table->decimal('last_salary', 10, 2)->nullable();
            $table->string('migrate_month');
            $table->string('data_entry_by');
            $table->unsignedBigInteger('user_id');
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes for better performance
            $table->index('original_worker_entry_id');
            $table->index('id_card_no');
            $table->index('migration_date');
            $table->index('migration_reason');
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
