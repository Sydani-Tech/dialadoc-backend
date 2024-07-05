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
        Schema::create('facility_appointments', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('patient_record_id');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->unsignedBigInteger('facility_id');
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->text('results');
            $table->string('documents_url');
            $table->timestamps();

            $table->foreign('patient_record_id')->references('id')->on('patient_records');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('facility_appointments');
    }
};
