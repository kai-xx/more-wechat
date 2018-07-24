<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatGraphic;
class CreateOaWechatGraphicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatGraphic::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatGraphic::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatGraphic::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->integer(WechatGraphic::DB_FILED_PARENT_ID)->default(0)->comment("父级ID");
            $table->string(WechatGraphic::DB_FILED_TITLE)->default("")->comment("标题");
            $table->text(WechatGraphic::DB_FILED_DETAIL)->default("")->comment("详情");
            $table->string(WechatGraphic::DB_FILED_AUTHOR)->default("")->comment("作者");
            $table->string(WechatGraphic::DB_FILED_PATH)->default("")->comment("图片路径");
            $table->string(WechatGraphic::DB_FILED_REMARK)->default("")->comment("备注");
            $table->tinyInteger(WechatGraphic::DB_FILED_TYPE)->default(3)->comment("1菜单,2关键词,3消息");
            $table->tinyInteger(WechatGraphic::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(WechatGraphic::TABLE_NAME);
    }
}