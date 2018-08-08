<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\MenuOptions;
class CreateMenuOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MenuOptions::TABLE_NAME, function (Blueprint $table) {
            $table->increments(MenuOptions::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(MenuOptions::DB_FILED_MANAGER_ID)
                ->default(0)
                ->comment("管理员ID");
            $table->integer(MenuOptions::DB_FILED_MENU_ID)->default(0)->comment("菜单ID");
            $table->tinyInteger(MenuOptions::DB_FILED_TYPE)->default(3)->comment("1文本,2图片,3图文,4链接,5视频,6音频");
            $table->tinyInteger(MenuOptions::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(MenuOptions::TABLE_NAME);
    }
}
