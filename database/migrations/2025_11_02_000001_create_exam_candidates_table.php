<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exam_candidates', function (Blueprint $table) {
            $table->id();
            $table->string('nid')->index();
            $table->string('name');
            $table->date('examination_date')->nullable();
            $table->boolean('exam_passed')->nullable();
            $table->json('result_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_candidates');
    }
};
