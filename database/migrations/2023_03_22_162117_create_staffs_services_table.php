<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('staffs_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('staff_id')->unsigned();
            $table->unsignedBiginteger('service_id')->unsigned();

            $table->foreign('staff_id')->references('id')
                ->on('staff')->cascadeOnDelete();
            $table->foreign('service_id')->references('id')
                ->on('services')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staffs_services');
    }
};
