<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatText;
class CreateOaWechatTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatText::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatText::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatText::DB_FILED_MANAGER_ID)
                ->default(0)
                ->comment("管理员ID");
            $table->integer(WechatText::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->integer(WechatText::DB_FILED_PARENT_ID)->default(0)->comment("父级ID");
            $table->text(WechatText::DB_FILED_TEXT)->default("")->comment("文本信息");
            $table->string(WechatText::DB_FILED_REMARK)->default("")->comment("备注");
            $table->tinyInteger(WechatText::DB_FILED_TYPE)->default(3)->comment("1菜单,2关键词,3消息");
            $table->tinyInteger(WechatText::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(WechatText::TABLE_NAME);
    }
}
