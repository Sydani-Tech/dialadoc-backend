<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionMedicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_medications', function (Blueprint $table) {
            $table->bigIncrements('prescription_medication_id'); // Changed to bigIncrements for primary key
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->unsignedBigInteger('medication_id')->nullable();
            $table->string('dosage', 100)->nullable();
            $table->string('frequency', 100)->nullable();
            $table->timestamps();

            $table->foreign('prescription_id')->references('prescription_id')->on('prescriptions');
            $table->foreign('medication_id')->references('medication_id')->on('medications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_medications');
    }
}
