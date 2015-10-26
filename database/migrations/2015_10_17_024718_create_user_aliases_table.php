<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAliasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_aliases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('provider');
            $table->string('alias');
            $table->string('type');
            $table->json('data');
            $table->timestamps();
            $table->index(['provider', 'alias']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_aliases');
    }
}
