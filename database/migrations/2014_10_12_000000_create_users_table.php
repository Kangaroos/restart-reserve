<?php

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
            $table->string('nickname');
            $table->string('mobile')->unique();
            $table->string('password', 60);
            $table->string('card_number'); //会员卡号
            $table->integer('fails_to_perform'); //爽约次数
            $table->char('level',3)->default('001');//会员等级
            $table->string('status')->default('active'); //active:正常  inactive:无效
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
        Schema::drop('users');
    }
}
