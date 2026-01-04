<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('exam_approvals', function (Blueprint $table) {
            $table->string('floor')->nullable()->after('requested_by');
            $table->string('line')->nullable()->after('floor');
            $table->decimal('special_case_salary', 10, 2)->nullable()->after('requested_salary');
            $table->string('special_case_reason')->nullable()->after('special_case_salary');
        });
    }

    public function down(): void
    {
        Schema::table('exam_approvals', function (Blueprint $table) {
            $table->dropColumn(['floor', 'line', 'special_case_salary', 'special_case_reason']);
        });
    }
};
