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
            $table->bigIncrements('record_id'); // Primary key as bigIncrements
            $table->unsignedBigInteger('patient_id')->nullable(); // Foreign key as unsignedBigInteger
            $table->unsignedBigInteger('doctor_id')->nullable(); // Foreign key as unsignedBigInteger
            $table->unsignedBigInteger('created_by')->nullable(); // Foreign key as unsignedBigInteger
            $table->integer('record_type')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('date_created')->default(now());
            $table->timestamps(); // Add timestamps for created_at and updated_at

            // Foreign key constraints
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('doctor_id')->on('doctors')->onDelete('cascade');
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
        Schema::dropIfExists('medical_records');
    }
}
