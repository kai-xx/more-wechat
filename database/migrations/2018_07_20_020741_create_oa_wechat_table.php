<?php
use App\OaWechat;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOaWechatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(OaWechat::TABLE_NAME, function (Blueprint $table) {
            $table->increments(OaWechat::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->string(OaWechat::DB_FILED_TOKEN)
                ->default("")
                ->comment("token");
            $table->string(OaWechat::DB_FILED_NAME)
                ->default("")
                ->comment("公众号名称");
            $table->string(OaWechat::DB_FILED_ORIGINAL_ID)
                ->default("")
                ->comment("公众号原始ID");
            $table->string(OaWechat::DB_FILED_WECHAT_NUMBER)
                ->default("")
                ->comment("公众号-号码");
            $table->string(OaWechat::DB_FILED_APP_ID)
                ->default("")
                ->comment("开发者ID");
            $table->string(OaWechat::DB_FILED_APP_SECRET)
                ->default("")
                ->comment("开发者密码");
            $table->string(OaWechat::DB_FILED_IMAGE)
                ->default()
                ->comment("公众号头像");
            $table->tinyInteger(OaWechat::DB_FILED_TYPE)
                ->default()
                ->comment("公总号类型");
            $table->tinyInteger(OaWechat::DB_FILED_STATE)
                ->default()
                ->comment("状态1有效2无效");
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
        Schema::dropIfExists('oa_wechat');
    }
}
