<?php

use App\Models\WechatFans;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOaWechatFansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatFans::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatFans::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatFans::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->string(WechatFans::DB_FILED_OPEN_ID     )->default("")->unique()->comment("open_id");
            $table->string(WechatFans::DB_FILED_NIKE        , 120)->default("")->comment("昵称");
            $table->string(WechatFans::DB_FILED_SEX         , 20)->default("")->comment("性别");
            $table->string(WechatFans::DB_FILED_HEAD_IMG    )->default("")->unique()->comment("头像");
            $table->string(WechatFans::DB_FILED_CITY        , 60)->default("")->comment("城市");
            $table->string(WechatFans::DB_FILED_ADDRESS     , 255)->default("")->comment("地址");
            $table->string(WechatFans::DB_FILED_COUNTRY, 70)->default("")->comment("国家");
            $table->string(WechatFans::DB_FILED_PROVINCE       , 70)->default("")->comment("省");
            $table->timestamp(WechatFans::DB_FILED_SUBSCRIBE_TIME)->nullable($value = true)->comment("关注时间");
            $table->integer(WechatFans::DB_FILED_GROUPID)->default(0)->comment("分组ID");
            $table->string(WechatFans::DB_FILED_REMARK         , 255)->default("")->comment("备注");
            $table->string(WechatFans::DB_FILED_SUBSCRIBE_SCENE, 255)->default("")->comment("关注方式");
            $table->string(WechatFans::DB_FILED_LATITUDE       , 255)->default("")->comment("纬度");
            $table->double(WechatFans::DB_FILED_LONGITUDE      , 15, 8)->default(0)->comment("经度");
            $table->double(WechatFans::DB_FILED_PRECISION      , 15, 8)->default(0)->comment("精度");
            $table->double(WechatFans::DB_FILED_UNIONID        , 15, 8)->default(0)->comment("");
            $table->string(WechatFans::DB_FILED_PHONE       , 16)->default("")->comment("电话");
            $table->string(WechatFans::DB_FILED_TAG_IDS)->default("")->comment("标签");
            $table->tinyInteger(WechatFans::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
            $table->tinyInteger(WechatFans::DB_FILED_SUBSCRIBE)->default(1)->comment("1关注0未关注");
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
        Schema::dropIfExists(WechatFans::TABLE_NAME);
    }
}
