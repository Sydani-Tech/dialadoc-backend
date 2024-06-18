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
        Schema::table('patients', function (Blueprint $table) {
            $table->text('average_heart_rate')->nullable()->after('surgical_history');
            $table->string('other_allergies')->nullable()->after('allergies_2');
            $table->text('other_condition')->nullable()->after('condition_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'average_heart_rate',
                'other_allergies',
                'other_condition'
            ]);
        });
    }
};
