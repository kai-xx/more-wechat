<?php
use \App\Models\Manager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Manager::TABLE_NAME, function (Blueprint $table) {
            $table->increments(Manager::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->string(Manager::DB_FILED_LOGIN_NAME, 16)
                ->default("")
                ->unique()
                ->comment("登录名");
            $table->string(Manager::DB_FILED_NAME, 60)
                ->default("")
                ->comment("姓名");
            $table->string(Manager::DB_FILED_PASSWORD)
                ->default("")
                ->comment("密码");
            $table->string(Manager::DB_FILED_PHONE, 15)
                ->default("")
                ->comment("电话");
            $table->string(Manager::DB_FILED_EMAIL, 128)
                ->default("")
                ->comment("邮箱");
            $table->string(Manager::DB_FILED_QQ, 20)
                ->default("")
                ->comment("QQ");
            $table->string(Manager::DB_FILED_WECHAT_NUMBER, 128)
                ->default("")
                ->comment("微信号");
            $table->integer(Manager::DB_FILED_OA_WECHAT_ID)
                ->default(0)
                ->comment("公众号ID");
            $table->integer(Manager::DB_FILED_PARENT_ID)
                ->default(0)
                ->comment("父级ID");
            $table->tinyInteger(Manager::DB_FILED_TYPE)
                ->default(2)
                ->comment("1管理员2公众号管理员3用户");
            $table->string(Manager::DB_FILED_LEVEL_MAP, 128)
                ->default("")
                ->comment("层级词典");
            $table->tinyInteger(Manager::DB_FILED_STATE)
                ->default(1)
                ->comment("1有效2无效");
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
        Schema::dropIfExists('manager');
    }
}
