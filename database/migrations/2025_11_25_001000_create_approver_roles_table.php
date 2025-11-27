<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApproverRolesTable extends Migration
{
    public function up()
    {
        Schema::create('approver_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('approver_roles');
    }
}
