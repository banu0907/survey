<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('survey')->comment('标题');
            $table->string('survey_alignment')->nullable()->comment('标题对齐方式');
            $table->string('survey_logo')->nullable()->comment('标志');
            $table->string('survey_theme')->nullable()->comment('背景主题风格');
            $table->string('tag')->nullable()->comment('标签');
            $table->string('multiple_responses')->nullable()->comment('重复次数');
            $table->integer('total_days')->unsigned()->nullable()->comment('周期总天数');
            $table->string('published')->nullable()->comment('发布完成');
            $table->string('collect_type')->nullable()->comment('收集方式');
            $table->string('edit_responses')->nullable()->comment('允许修改');
            $table->string('make_anonymous')->nullable()->comment('匿名');
            $table->boolean('instant_results')->default(false)->nullable()->comment('即时结果');
            $table->boolean('use_ssl')->default(false)->nullable()->comment('SSL 加密');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('end_time')->nullable()->comment('截止结束时间');
            $table->integer('max_responses')->unsigned()->nullable()->comment('回复限制');
            $table->string('ipaccess')->nullable()->comment('IP限制');
            $table->string('password_protection')->nullable()->comment('密码保护');
            $table->integer('person_time')->unsigned()->default(0)->comment('使用人次');
            $table->integer('replies_sum')->unsigned()->default(0)->comment('使用总次数');
            $table->integer('get_points')->unsigned()->default(0)->comment('用户完成可获得积分');
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
        Schema::dropIfExists('surveys');
    }
}
