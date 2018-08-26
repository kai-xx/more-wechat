<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\IndustryMessageSendLog;
class CreateOaWechatIndustryMessageSendLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(IndustryMessageSendLog::TABLE_NAME, function (Blueprint $table) {
            $table->increments(IndustryMessageSendLog::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(IndustryMessageSendLog::DB_FILED_INDUSTRY_MESSAGE_ID)->default(0)->comment("消息ID");
            $table->integer(IndustryMessageSendLog::DB_FILED_FANS_ID)->default(0)->comment("粉丝ID");
            $table->integer(IndustryMessageSendLog::DB_FILED_STATUS)->default(0)->comment("1成功2失败");
            $table->string(IndustryMessageSendLog::DB_FILED_REASON, 255)->default('')->comment("原因");
            $table->tinyInteger(IndustryMessageSendLog::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(IndustryMessageSendLog::TABLE_NAME);
    }
}
