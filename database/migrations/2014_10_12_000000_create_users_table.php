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
            $table->id();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('is_admin',['1','0'])->comment('1 success, 2 invited, 3 pin send')->default('0');
            $table->tinyInteger('status')->comment('0 for nothing, 1 success, 2 invited, 3 pin send')->default('0');
            $table->integer('otp')->comment('6 digit code')->nullable();;
            $table->integer('after_otp')->unique()->comment('6 digit code send to email')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
