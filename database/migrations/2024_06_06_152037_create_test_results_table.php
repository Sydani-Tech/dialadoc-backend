<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->integer('test_result_id')->primary();
            $table->integer('record_id')->nullable();
            $table->string('test_name', 100)->nullable();
            $table->text('result')->nullable();
            $table->date('date_performed')->nullable();
            $table->integer('created_by')->nullable();

            $table->foreign('record_id')->references('record_id')->on('medical_records');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
