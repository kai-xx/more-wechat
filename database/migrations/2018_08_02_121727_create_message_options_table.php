<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\MessageOptions;

class CreateMessageOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MessageOptions::TABLE_NAME, function (Blueprint $table) {
            $table->increments(MessageOptions::DB_FILED_ID)
                ->bigIncrements()
                ->comment("主键ID");
            $table->integer(MessageOptions::DB_FILED_MANAGER_ID)
                ->default(0)
                ->comment("管理员ID");
            $table->integer(MessageOptions::DB_FILED_RESOURCE_ID)
                ->default(0)
                ->comment("资源ID");
            $table->integer(MessageOptions::DB_FILED_MESSAGE_ID)->default(0)->comment("信息ID");
            $table->tinyInteger(MessageOptions::DB_FILED_STATE)->default(1)->comment("1开启2关闭");
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
        Schema::dropIfExists(MessageOptions::TABLE_NAME);
    }
}
