<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->index()->comment('问卷id');
            $table->integer('survey_page_id')->unsigned()->index()->comment('页序id');
            $table->integer('question_num')->unsigned()->default(0)->comment('题序');
            $table->string('question_type')->comment('问题类型');
            $table->string('title')->comment('题目');
            $table->text('content')->comment('题目内容');
            $table->text('content_show')->nullable()->comment('题目内容HTML显示');
            $table->boolean('required_question')->default(false)->nullable()->comment('是否为必答题');
            $table->string('required_text')->nullable()->comment('必答提示');
            $table->string('item_random')->nullable()->comment('选项随机排列');
            $table->boolean('item_last_fix')->default(false)->nullable()->comment('最后选项不随机');
            $table->string('question_logic')->nullable()->comment('问题逻辑');
            $table->boolean('deleted_flag')->default(false)->nullable()->comment('删除标记');

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
        Schema::dropIfExists('questions');
    }
}
