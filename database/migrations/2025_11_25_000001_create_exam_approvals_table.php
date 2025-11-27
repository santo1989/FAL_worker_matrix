<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_candidate_id')->constrained('exam_candidates')->cascadeOnDelete();
            $table->unsignedBigInteger('requested_by')->nullable();
            $table->decimal('requested_salary', 10, 2)->nullable();
            $table->string('type')->nullable(); // agreed | negotiation
            $table->string('status')->default('pending'); // pending | approved | rejected
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_approvals');
    }
};
