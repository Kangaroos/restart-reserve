<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('store_id');
            $table->string('store_name');
            $table->integer('coach_id');
            $table->string('coach_name');
            $table->integer('classroom_id');
            $table->string('classroom_name');
            $table->timestamp('class_date'); //课程日期
            $table->time('class_time_begin'); //课程开始时间
            $table->time('class_time_end'); //课程结束时间
            $table->string('week'); //星期几
            $table->longText('description');
            $table->longText('needing_attention'); //注意事项
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
        Schema::drop('courses');
    }
}
