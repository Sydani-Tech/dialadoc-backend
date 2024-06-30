<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id('id');
            $table->string('logo_url')->nullable();
            $table->string('facility_name')->nullable();
            $table->string('role_in_facility')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('helpdesk_email')->nullable();
            $table->string('helpdesk_number')->nullable();
            $table->integer('number_of_staff')->nullable();
            $table->date('year_of_inception')->nullable();
            $table->string('facility_type')->nullable();
            $table->string('cac_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('facilities');
    }
};
