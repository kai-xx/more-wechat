<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WechatMessage extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_message';
    protected $table = self::TABLE_NAME;



    const DB_FILED_ID                  = 'id';
    const DB_FILED_MANAGER_ID          = 'manager_id';
    const DB_FILED_OA_WECHAT_ID        = 'oa_wechat_id';
    const DB_FILED_TITLE               = 'title';
    const DB_FILED_TYPE                = 'type';
    const DB_FILED_MESSAGE_TYPE        = 'message_type';
    const DB_FILED_STATE               = 'state';
    const DB_FILED_IS_PUSH             = 'is_push';
    const DB_FILED_REMARK              = 'remark';
    const DB_FILED_SEND_AT             = 'send_at';
    const DB_FILED_CREATED_AT          = 'created_at';
    const DB_FILED_UPDATE_AT           = 'update_at';
    const DB_FILED_DELETE_AT           = 'delete_at';

    const TYPE_TEXT                    = 1; // 关键词类型：文本
    const TYPE_IMAGE                   = 2; // 关键词类型：图片
    const TYPE_GRAPHIC                 = 3; // 关键词类型：图文
    const TYPE_URI                     = 4; // 关键词类型：链接
    const TYPE_VIDEO                   = 5; // 关键词类型：视频
    const TYPE_VOICE                   = 6; // 关键词类型：音频

    const TYPE_OTHER                   = 1;
    const TYPE_TIMING                  = 2;

    const NOT_PUSH                     = 1;
    const HAVE_PUSH                    = 2;

    const STATE_OPEN                   = 1; // 开启
    const STATE_CLOSE                  = 2; // 关闭
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_TITLE,
        self::DB_FILED_MANAGER_ID,
        self::DB_FILED_OA_WECHAT_ID,
        self::DB_FILED_REMARK,
        self::DB_FILED_IS_PUSH,
        self::DB_FILED_TYPE,
        self::DB_FILED_MESSAGE_TYPE,
        self::DB_FILED_STATE,
        self::DB_FILED_SEND_AT,
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