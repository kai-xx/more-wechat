<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatKeyword;
class CreateOaWechatKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatKeyword::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatKeyword::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatKeyword::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->string(WechatKeyword::DB_FILED_KEYWORD)->default("")->comment("关键词");
            $table->string(WechatKeyword::DB_FILED_REMARK)->default("")->comment("备注");
            $table->tinyInteger(WechatKeyword::DB_FILED_TYPE)->default(3)->comment("1文本,2图片,3图文,4链接,5视频,6音频");
            $table->tinyInteger(WechatKeyword::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(WechatKeyword::TABLE_NAME);
    }
}
