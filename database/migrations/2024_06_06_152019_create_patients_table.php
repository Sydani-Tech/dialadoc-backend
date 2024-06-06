<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->integer('patient_id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('gender')->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('genotype', 10)->nullable();
            $table->integer('location_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('patients');
    }
}
