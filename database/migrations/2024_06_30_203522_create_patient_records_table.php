<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->string('update_type');
            $table->string('suspected_illness');
            $table->text('findings');
            $table->text('recommended_tests');
            $table->unsignedBigInteger('recommended_facility')->nullable();
            $table->text('prescriptions');
            $table->timestamps();

            $table->foreign('patient_id')->references('patient_id')->on('patients');
            $table->foreign('recommended_facility')->references('id')->on('facilities');
            $table->foreign('appointment_id')->references('appointment_id')->on('appointments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('patient_records');
    }
};
