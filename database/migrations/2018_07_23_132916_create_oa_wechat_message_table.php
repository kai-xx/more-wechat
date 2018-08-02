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
            $table->integer(WechatMessage::DB_FILED_MANAGER_ID)
                ->default(0)
                ->comment("管理员ID");
            $table->integer(WechatMessage::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->tinyInteger(WechatMessage::DB_FILED_TYPE)->default(1)->comment("1普通,2定时");
            $table->tinyInteger(WechatMessage::DB_FILED_IS_PUSH)->default(1)->comment("1未推送2已推送");
            $table->tinyInteger(WechatMessage::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
            $table->string(WechatMessage::DB_FILED_REMARK,255)->default("")->comment("备注");
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
