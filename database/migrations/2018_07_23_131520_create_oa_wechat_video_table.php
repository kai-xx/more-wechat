<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatVideo;
class CreateOaWechatVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatVideo::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatVideo::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatVideo::DB_FILED_MANAGER_ID)
                ->default(0)
                ->comment("管理员ID");
            $table->integer(WechatVideo::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->integer(WechatVideo::DB_FILED_PARENT_ID)->default(0)->comment("父级ID");
            $table->string(WechatVideo::DB_FILED_PATH)->default("")->comment("视频路径");
            $table->string(WechatVideo::DB_FILED_REMARK)->default("")->comment("备注");
            $table->tinyInteger(WechatVideo::DB_FILED_TYPE)->default(3)->comment("1菜单,2关键词,3消息");
            $table->tinyInteger(WechatVideo::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(WechatVideo::TABLE_NAME);
    }
}
