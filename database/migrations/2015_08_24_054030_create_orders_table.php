<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('order_no')->unique(); //order  规则:yyyyMMdd + reserve_id
            $table->integer('user_id');
            $table->integer('reserve_id');
            $table->integer('course_id');
            $table->string('seat_number');
            $table->string('status')->default('verify'); // verify:待核销, complete:已核销, cancel:已取消
            $table->text('remark');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
