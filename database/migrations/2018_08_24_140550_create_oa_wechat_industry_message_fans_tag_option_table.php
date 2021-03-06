<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\IndustryMessageFansTagOption;
class CreateOaWechatIndustryMessageFansTagOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(IndustryMessageFansTagOption::TABLE_NAME, function (Blueprint $table) {
            $table->increments(IndustryMessageFansTagOption::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(IndustryMessageFansTagOption::DB_FILED_INDUSTRY_MESSAGE_ID)->default(0)->comment("消息ID");
            $table->integer(IndustryMessageFansTagOption::DB_FILED_TAG_ID)->default(0)->comment("标签ID");
            $table->tinyInteger(IndustryMessageFansTagOption::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(IndustryMessageFansTagOption::TABLE_NAME);
    }
}
