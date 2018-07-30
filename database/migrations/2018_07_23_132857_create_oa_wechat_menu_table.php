<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatMenu;
class CreateOaWechatMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatMenu::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatMenu::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatMenu::DB_FILED_MANAGER_ID)
                ->default(0)
                ->comment("管理员ID");
            $table->integer(WechatMenu::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->integer(WechatMenu::DB_FILED_PARENT_ID)->default(0)->comment("父级ID");
            $table->integer(WechatMenu::DB_FILED_LEVEL)->default(0)->comment("层级");
            $table->integer(WechatMenu::DB_FILED_SORT)->default(0)->comment("排序");
            $table->string(WechatMenu::DB_FILED_NAME)->default("")->comment("菜单名称");
            $table->tinyInteger(WechatMenu::DB_FILED_TYPE)->default(3)->comment("1文本,2图片,3图文,4链接,5视频,6音频");
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
        Schema::dropIfExists(WechatMenu::TABLE_NAME);
    }
}
