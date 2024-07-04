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
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('appointment_id');

            $table->foreignId('patient_id');
            $table->foreignId('doctor_id');
            $table->string('affected_body_part');
            $table->string('nature_of_illness');
            $table->string('type_of_appointment');
            $table->text('description');
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable(); // Match the data type with the primary key in 'appointments'
            $table->text('notes')->nullable();

            $table->foreign('appointment_id')->references('appointment_id')->on('appointments')->onDelete('cascade');

            $table->dropColumn('patient_id');
            $table->dropColumn('doctor_id');
            $table->dropColumn('affected_body_part');
            $table->dropColumn('nature_of_illness');
            $table->dropColumn('type_of_appointment');
            $table->dropColumn('description');
        });
    }
};
