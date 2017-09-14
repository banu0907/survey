<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id')->unsigned()->index()->comment('问题id');
            $table->string('tag')->index()->comment('答项标识ID');
            $table->integer('order_num')->unsigned()->nullable()->comment('答项排序');
            $table->string('answer')->nullable()->comment('答项描述');
            $table->integer('total_num')->unsigned()->nullable()->comment('回答统计数');
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
        Schema::dropIfExists('answers');
    }
}
