<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('service_id')
                ->nullable()
                ->references('id')
                ->on('services')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('phone')->index();
            $table->text('content')->nullable();
            $table->unsignedSmallInteger('status')->default(0);

            $table->unsignedInteger('tries')->default(0);

//            $table->unsignedSmallInteger('process_number')->default(0);
            $table
                ->foreignId('usb_id')
                ->nullable()
                ->references('id')
                ->on('usbs')
                ->nullOnDelete();

            $table->dateTime('completed_at')->nullable();

            $table->unsignedSmallInteger('type')->default(0);

            $table
                ->foreignId('distribution_id')
                ->nullable()
                ->references('id')
                ->on('distributions')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('sms');
    }
}
