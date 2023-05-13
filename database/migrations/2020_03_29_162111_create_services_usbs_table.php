<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_usbs', function (Blueprint $table) {
            //regions_stores
            $table->id();
            $table->unsignedBiginteger('service_id')->unsigned();
            $table->unsignedBiginteger('usb_id')->unsigned();

            $table->foreign('service_id')->references('id')
                ->on('services')->onDelete('cascade');
            $table->foreign('usb_id')->references('id')
                ->on('usbs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services_usbs');
    }
};
