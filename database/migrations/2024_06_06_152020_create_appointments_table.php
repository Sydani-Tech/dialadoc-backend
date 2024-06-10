<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->integer('appointment_id')->primary();
            $table->integer('doctor_id')->nullable();
            $table->integer('patient_id')->nullable();
            $table->dateTime('appointment_date')->nullable();
            $table->string('affected_body_part')->nullable();
            $table->string('nature_of_illness')->nullable();
            $table->string('type_of_appointment')->nullable();
            $table->text('description_of_illness')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('status');

            $table->foreign('doctor_id')->references('doctor_id')->on('doctors');
            $table->foreign('patient_id')->references('patient_id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
