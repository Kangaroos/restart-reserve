<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('file_entries_id')->comment('封面文件ID');
            $table->string('mobile');
            $table->string('address');
            $table->decimal('lat', 15, 8);
            $table->decimal('lng', 15, 8);
            $table->longText('description');
            $table->timestamp('startup_at');
            $table->string('status')->default('active'); //active:正常 inactive:无效
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
        Schema::drop('stores');
    }
}
