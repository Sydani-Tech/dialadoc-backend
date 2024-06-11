<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->bigIncrements('insurance_id'); // Primary key as bigIncrements
            $table->unsignedBigInteger('patient_id')->nullable(); // Foreign key as unsignedBigInteger
            $table->string('provider_name', 100)->nullable();
            $table->string('policy_number', 50)->nullable();
            $table->text('coverage_details')->nullable();
            $table->timestamps(); // Add timestamps for created_at and updated_at

            // Foreign key constraint
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurances');
    }
}
