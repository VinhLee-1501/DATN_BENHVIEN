<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('row_id')->primary();
            $table->string('user_id')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('avatar')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password'); // Chỉ cần khai báo một lần
            $table->date('birthday')->nullable();
            $table->string('phone', 10)->unique()->nullable();
            $table->string('google_id')->nullable();
            $table->string('zalo_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->tinyInteger('role')->default(0)->comment('1 là admin, 2 là bác sĩ, 0 là user');
            $table->tinyInteger('status')->default(1)->comment('1 là hoạt động');
            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
