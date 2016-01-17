<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->timestamp('class_date'); //课程日期
            $table->string('week'); //星期几
            $table->string('status')->default('pending'); //pending:待发布  approved:已发布
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
        Schema::drop('course_schedules');
    }
}
