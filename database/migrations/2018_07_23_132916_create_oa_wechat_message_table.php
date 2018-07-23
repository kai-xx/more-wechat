<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatMessage;
class CreateOaWechatMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatMessage::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatMessage::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatMessage::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->integer(WechatMessage::DB_FILED_PARENT_ID)->default(0)->comment("父级ID");
            $table->tinyInteger(WechatMessage::DB_FILED_TYPE)->default(3)->comment("1文本,2图片,3图文,4链接,5视频,6音频");
            $table->tinyInteger(WechatMessage::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
            $table->timestamp(WechatMessage::DB_FILED_SEND_AT)->nullable($value = true)->comment("发送时间");
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
        Schema::dropIfExists(WechatMessage::TABLE_NAME);
    }
}
