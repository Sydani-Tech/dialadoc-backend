<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->bigIncrements('report_id'); // Changed to bigIncrements for primary key
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->date('report_date')->nullable();
            $table->text('progress_description')->nullable();
            $table->timestamps();

            $table->foreign('plan_id')->references('plan_id')->on('treatment_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progress_reports');
    }
}
