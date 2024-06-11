<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('doctor_id'); // Primary key for the doctors table
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('specialization_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('mdcn_license', 100)->nullable();
            $table->string('cpd_annual_license', 100)->nullable();
            $table->string('bank_details')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('specialization_id')->references('specialization_id')->on('specializations');
            $table->foreign('location_id')->references('location_id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
