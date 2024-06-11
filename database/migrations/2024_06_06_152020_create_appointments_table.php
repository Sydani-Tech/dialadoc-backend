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
            $table->bigIncrements('appointment_id'); // bigIncrements makes it unsigned by default
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->dateTime('appointment_date')->nullable();
            $table->string('affected_body_part')->nullable();
            $table->string('nature_of_illness')->nullable();
            $table->dateTime('type_of_appointment')->nullable();
            $table->text('description_of_illness')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();

            $table->foreign('doctor_id')->references('doctor_id')->on('doctors');
            $table->foreign('patient_id')->references('patient_id')->on('patients');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade'); // Ensure this matches the data type in the users table
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
