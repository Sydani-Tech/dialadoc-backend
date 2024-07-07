<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropForeign(['patient_id']);
            $table->dropColumn('doctor_id')->nullable();
            $table->dropColumn('patient_id')->nullable();
            $table->dropColumn('affected_body_part')->nullable();
            $table->dropColumn('nature_of_illness')->nullable();
            $table->dropColumn('type_of_appointment')->nullable();
            $table->dropColumn('description_of_illness')->nullable();
            $table->dropColumn('status');

            $table->foreignId('consultation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->bigIncrements('appointment_id'); // bigIncrements makes it unsigned by default
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('affected_body_part')->nullable();
            $table->string('nature_of_illness')->nullable();
            $table->dateTime('type_of_appointment')->nullable();
            $table->text('description_of_illness')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');

            $table->foreign('doctor_id')->references('doctor_id')->on('doctors');
            $table->foreign('patient_id')->references('patient_id')->on('patients');

            $table->dropColumn('consultation_id');
        });
    }
};
