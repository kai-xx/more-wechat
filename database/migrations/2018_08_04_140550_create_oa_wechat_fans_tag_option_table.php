<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\WechatFansTagOption;
class CreateOaWechatFansTagOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(WechatFansTagOption::TABLE_NAME, function (Blueprint $table) {
            $table->increments(WechatFansTagOption::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(WechatFansTagOption::DB_FILED_FANS_ID)->default(0)->comment("粉丝ID");
            $table->integer(WechatFansTagOption::DB_FILED_TAG_ID)->default(0)->comment("标签ID");
            $table->tinyInteger(WechatFansTagOption::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(WechatFansTagOption::TABLE_NAME);
    }
}
