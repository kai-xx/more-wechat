<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\IndustryMessage;

class CreateOaWechatIndustryMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(IndustryMessage::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id')
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(IndustryMessage::DB_FILED_INDUSTRY_ID)->default(0)->comment("模版消息ID");
            $table->integer(IndustryMessage::DB_FILED_MANAGER_ID)->default(0)->comment("管理员ID");
            $table->string(IndustryMessage::DB_FILED_APPLET_APP_ID, 255)->default('')->comment("小程序appID");
            $table->string(IndustryMessage::DB_FILED_APPLET_URI, 255)->default('')->comment("跳转链接");
            $table->string(IndustryMessage::DB_FILED_APPLET_PATH, 255)->default('')->comment("小程序链接");
            $table->text(IndustryMessage::DB_FILED_CONTENT)->comment("模版内容");
            $table->string(IndustryMessage::DB_FILED_REMARK, 255)->default('')->comment("备注");
            $table->tinyInteger(IndustryMessage::DB_FILED_TYPE)->default(1)->comment("1普通2定时");
            $table->tinyInteger(IndustryMessage::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
            $table->timestamp(IndustryMessage::DB_FILED_SEND_AT)->nullable($value = true)->comment("发送时间");
            $table->softDeletes();
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
        Schema::dropIfExists(IndustryMessage::TABLE_NAME);
    }
}
