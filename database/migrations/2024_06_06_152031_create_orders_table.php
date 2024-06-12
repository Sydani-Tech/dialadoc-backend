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
            $table->bigIncrements('order_id'); // Change to bigIncrements for primary key
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->unsignedBigInteger('pharmacy_id')->nullable();
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('order_date')->default(now());
            $table->enum('order_type', ['consultation', 'prescription']); // Assuming it's ENUM
            $table->enum('status', ['pending', 'completed', 'cancelled']); // Assuming it's ENUM

            $table->timestamps();
            
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
