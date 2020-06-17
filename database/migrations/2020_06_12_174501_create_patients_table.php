<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->string('sex')->comment('性别')->nullable();
            $table->integer('age')->comment('年龄')->nullable();
            $table->string('tel')->comment('电话')->nullable();
            $table->string('qq')->comment('QQ号')->nullable();
            $table->string('wechat')->comment('微信号')->nullable();
            $table->mediumText('content')->comment('内容总结')->nullable();
            $table->string('department_id')->comment('科室：关联科室表')->nullable();
            $table->string('engine_id')->comment('渠道：关联媒体表');
            $table->string('media_id')->comment('来源：关联搜索引擎表');
            $table->string('keyword')->comment('关键字')->nullable();
            $table->string('area_id')->comment('地区')->default(0);
            $table->integer('admin_user_id')->comment('客服：关联用户表')->nullable();
            $table->integer('author_id')->comment('作者：关联用户表');
            $table->integer('doctor_a_id')->comment('预约专家：关联专家表')->nullable();
            $table->integer('doctor_b_id')->comment('主治医生：关联专家表')->nullable();
            $table->timestamp('come_time')->comment('预约时间')->nullable();
            $table->timestamp('visit_time')->comment('回访时间')->nullable();
            $table->timestamp('arrive_time')->comment('到院时间')->nullable();
            $table->integer('status')->comment('到院状态:0未到-1已到-2不来了')->default(0);
            $table->text('memo')->comment('备注')->nullable();
            $table->text('edit_log')->comment('修改记录')->nullable();
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
        Schema::dropIfExists('patients');
    }
}
