<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WechatText extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_text';
    protected $table = self::TABLE_NAME;



    const DB_FILED_ID                  = 'id';
    const DB_FILED_OA_WECHAT_ID        = 'oa_wechat_id';
    const DB_FILED_PARENT_ID           = 'parent_id';
    const DB_FILED_TEXT                = 'text';
    const DB_FILED_REMARK              = 'remark';
    const DB_FILED_TYPE                = 'type';
    const DB_FILED_STATE               = 'state';

    const DB_FILED_CREATED_AT          = 'created_at';
    const DB_FILED_UPDATE_AT           = 'update_at';
    const DB_FILED_DELETE_AT           = 'delete_at';

    const TYPE_MENU                    = 1; // 类型：菜单
    const TYPE_KEYWORD                 = 2; // 类型：关键词
    const TYPE_MESSAGE                 = 3; // 类型：消息

    const STATE_OPEN                   = 1; // 开启
    const STATE_CLOSE                  = 2; // 关闭
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_OA_WECHAT_ID,
        self::DB_FILED_PARENT_ID,
        self::DB_FILED_TEXT,
        self::DB_FILED_REMARK,
        self::DB_FILED_TYPE,
        self::DB_FILED_STATE,
        self::DB_FILED_CREATED_AT,
        self::DB_FILED_UPDATE_AT,
        self::DB_FILED_DELETE_AT,
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array */
    protected $guarded = [

    ];
}