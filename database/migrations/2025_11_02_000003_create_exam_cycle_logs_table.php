<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_cycle_logs', function (Blueprint $table) {
            $table->id();
            // cascade when candidate is deleted, but do NOT cascade from process entry to avoid
            // multiple cascade paths on SQL Server. The process_entry FK will use NO ACTION on delete.
            $table->foreignId('exam_candidate_id')->constrained('exam_candidates')->cascadeOnDelete();
            $table->foreignId('exam_process_entry_id')->constrained('exam_process_entries')->onDelete('NO ACTION');
            $table->integer('rejectDataStatus')->default(0);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->decimal('duration', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_cycle_logs');
    }
};
