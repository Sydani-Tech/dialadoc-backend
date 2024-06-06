<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('order_id')->primary();
            $table->integer('prescription_id')->nullable();
            $table->integer('pharmacy_id')->nullable();
            $table->integer('consultation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('order_date')->default(now());
            $table->integer('order_type');
            $table->integer('status');

            $table->foreign('prescription_id')->references('prescription_id')->on('prescriptions');
            $table->foreign('pharmacy_id')->references('pharmacy_id')->on('pharmacies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
