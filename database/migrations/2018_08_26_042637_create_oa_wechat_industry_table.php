<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Industry;

class CreateOaWechatIndustryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Industry::TABLE_NAME, function (Blueprint $table) {
            $table->increments('id')
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(Industry::DB_FILED_OA_WECHAT_ID)->default(0)->comment("公众号ID");
            $table->string(Industry::DB_FILED_TEMPLATE_ID, 255)->default('')->comment("模版ID");
            $table->string(Industry::DB_FILED_TITLE, 255)->default('')->comment("模版标题");
            $table->string(Industry::DB_FILED_PRIMARY_INDUSTRY, 255)->default('')->comment("模版所属一级行业");
            $table->string(Industry::DB_FILED_DEPUTY_INDUSTRY, 255)->default('')->comment("模版所属二级行业");
            $table->text(Industry::DB_FILED_CONTENT)->comment("模版内容");
            $table->text(Industry::DB_FILED_EXAMPLE)->comment("模版示例");
            $table->string(Industry::DB_FILED_REMARK, 255)->default('')->comment("备注");
            $table->tinyInteger(Industry::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(Industry::TABLE_NAME);
    }
}
