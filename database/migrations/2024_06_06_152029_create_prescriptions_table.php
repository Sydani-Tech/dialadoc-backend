<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('prescription_id'); // Use bigIncrements for primary key
            $table->unsignedBigInteger('doctor_id')->nullable(); // Use unsignedBigInteger for foreign keys
            $table->unsignedBigInteger('patient_id')->nullable(); // Use unsignedBigInteger for foreign keys
            $table->date('date_issued')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // Use unsignedBigInteger for foreign keys
            $table->timestamps();
            
            $table->foreign('doctor_id')->references('doctor_id')->on('doctors');
            $table->foreign('patient_id')->references('patient_id')->on('patients');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
