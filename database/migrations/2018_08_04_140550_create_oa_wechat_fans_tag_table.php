<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatFansTag;
class CreateOaWechatFansTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatFansTag::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatFansTag::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatFansTag::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->integer(WechatFansTag::DB_FILED_TAG_ID)->default(0)->comment("标签ID");
            $table->string(WechatFansTag::DB_FILED_TAG_NAME)->default("")->unique()->comment("标签名称");
            $table->integer(WechatFansTag::DB_FILED_COUNT)->default(0)->comment("fans总数");
            $table->tinyInteger(WechatFansTag::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(WechatFansTag::TABLE_NAME);
    }
}
