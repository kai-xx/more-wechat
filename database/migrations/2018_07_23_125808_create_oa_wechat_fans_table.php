<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatFans;
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
            $table->string(WechatFans::DB_FILED_NIKE        , 120)->default("")->unique()->comment("昵称");
            $table->string(WechatFans::DB_FILED_SEX         , 20)->default("")->unique()->comment("性别");
            $table->string(WechatFans::DB_FILED_HEAD_IMG    )->default("")->unique()->comment("头像");
            $table->string(WechatFans::DB_FILED_CITY        , 60)->default("")->unique()->comment("城市");
            $table->string(WechatFans::DB_FILED_ADDRESS     , 255)->default("")->unique()->comment("地址");
            $table->string(WechatFans::DB_FILED_PHONE       , 16)->default("")->unique()->comment("电话");
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
