<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_metrics', function (Blueprint $table) {
            $table->morphs('metric');
            $table->integer('patient_id')->nullable();
            $table->string('value', 100)->nullable();
            $table->date('measurement_date')->nullable();
            $table->integer('created_by')->nullable();

            $table->primary(['metric_id']);
            $table->foreign('patient_id')->references('patient_id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_metrics');
    }
}
