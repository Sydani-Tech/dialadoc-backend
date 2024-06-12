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
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->text('bio')->nullable();
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['location_id']);

            $table->dropColumn([
                'location_id',
                'bank_details'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn([
                'bank_name',
                'bank_account_number',
                'country',
                'state',
                'lga',
                'bio'
            ]);
        });
    }
};
