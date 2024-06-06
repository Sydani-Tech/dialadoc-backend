<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->integer('record_id')->primary();
            $table->integer('patient_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('record_type')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('date_created')->default(now());

            $table->foreign('patient_id')->references('patient_id')->on('patients');
            $table->foreign('doctor_id')->references('doctor_id')->on('doctors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
}
