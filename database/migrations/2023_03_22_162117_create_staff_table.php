<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            $table->string('firstname')->index();
            $table->string('lastname')->index();

            $table->string('phone', 15)->unique()->nullable();
            $table->string('email')->unique()->nullable();

            $table->string('password');

            $table->string('role');

            $table->boolean('status')->default(true);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
