<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigInteger('user_id')->primary();
            $table->string('username', 50)->unique('username');
            $table->string('password_hash');
            $table->string('email', 100)->unique('email');
            $table->enum('role', ['patient', 'doctor', 'nurse', 'lab', 'hospital', 'pharmacy', 'admin']);
            $table->timestamp('created_at')->default('current_timestamp()');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
