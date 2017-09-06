<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned()->index();
            $table->integer('page_num')->unsigned()->comment('排序页号');
            $table->string('page_title')->nullable()->comment('页面标题');
            $table->string('page_description')->nullable()->comment('页面描述');
            $table->string('page_logic')->nullable()->comment('跳页逻辑');
            $table->string('question_random')->nullable()->comment('问题随机出现');
            $table->string('page_random')->nullable()->comment('页面随机出现');

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
        Schema::dropIfExists('survey_pages');
    }
}
