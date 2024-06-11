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
            $table->bigIncrements('metric_id'); // Using bigIncrements to auto-increment
            $table->unsignedBigInteger('patient_id')->nullable(); // Ensure this matches the type in 'patients' table
            $table->string('value', 100)->nullable();
            $table->date('measurement_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // Assuming it references 'id' in 'users' table

            // Foreign key constraints
            $table->foreign('patient_id')->references('patient_id')->on('patients')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('health_metrics');
    }
}
