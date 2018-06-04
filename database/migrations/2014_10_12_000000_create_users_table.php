<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->unsignedInteger('account')->default(0);
            $table->unsignedInteger('tickets_qty')->default(0);
            $table->string('api_token', 60)->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('openid');
            $table->string('avatar');
            $table->smallInteger('rank')->unsigned()->default(1);
            $table->smallInteger('rank_remain')->unsigned()->default(0);
            $table->unsignedInteger('points')->default(0);
            $table->string('qrcode_ticket')->nullable();
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
