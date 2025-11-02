<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_process_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_candidate_id')->constrained('exam_candidates')->cascadeOnDelete();
            $table->unsignedBigInteger('sewing_process_list_id')->nullable();
            $table->string('sewing_process_name')->nullable();
            $table->string('sewing_process_type')->nullable();
            $table->decimal('sewing_process_avg_cycles', 8, 2)->nullable();
            $table->decimal('smv', 8, 2)->nullable();
            $table->integer('target')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('self_production')->nullable();
            $table->integer('achive_production')->nullable();
            $table->decimal('efficiency', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_process_entries');
    }
};
