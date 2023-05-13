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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('service_id')
                ->nullable()
                ->references('id')
                ->on('services')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('excel_link');
            $table->smallInteger('state')->default(0);

            $table->dateTime('start_time')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->integer('message_count')->default(0);
            $table->integer('completed_count')->default(0);

            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('distributions');
    }
};
