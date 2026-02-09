<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonalInfoToWorkerEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_entries', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('employee_name_english');
            $table->string('husband_name')->nullable()->after('father_name');
            $table->text('present_address')->nullable()->after('mobile');
            $table->text('permanent_address')->nullable()->after('present_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worker_entries', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'husband_name', 'present_address', 'permanent_address']);
        });
    }
}
