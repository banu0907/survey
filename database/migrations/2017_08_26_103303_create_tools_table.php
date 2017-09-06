<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('题型名称');
            $table->string('code')->index()->comment('题型代号');
            $table->string('icon')->nullable()->comment('图标');
            $table->integer('sort_num')->nullable()->comment('排序');
            $table->text('tips')->nullable()->comment('提示');
            $table->text('tpl_out')->nullable()->comment('HTML输出模版');
            $table->integer('user_type')->nullable()->comment('会员使用权限级别');
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
        Schema::dropIfExists('tools');
    }
}
