<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consents', function (Blueprint $table) {
            $table->integer('consent_id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->integer('consent_type')->nullable();
            $table->boolean('granted')->default(0);
            $table->timestamp('consent_date')->default(now());

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('consents');
    }
}
