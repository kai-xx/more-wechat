<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WechatMenu extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_menu';
    protected $table = self::TABLE_NAME;



    const DB_FILED_ID                  = 'id';
    const DB_FILED_OA_WECHAT_ID        = 'oa_wechat_id';
    const DB_FILED_PARENT_ID           = 'parent_id';
    const DB_FILED_LEVEL               = 'level';
    const DB_FILED_SORT                = 'sort';
    const DB_FILED_NAME                = 'name';
    const DB_FILED_TYPE                = 'type';

    const DB_FILED_CREATED_AT          = 'created_at';
    const DB_FILED_UPDATE_AT           = 'update_at';
    const DB_FILED_DELETE_AT           = 'delete_at';

    const TYPE_TEXT                    = 1; // 菜单类型：文本
    const TYPE_IMAGE                   = 2; // 菜单类型：图片
    const TYPE_GRAPHIC                 = 3; // 菜单类型：图文
    const TYPE_URI                     = 4; // 菜单类型：链接
    const TYPE_VIDEO                   = 5; // 菜单类型：视频
    const TYPE_VOICE                   = 6; // 菜单类型：音频
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_OA_WECHAT_ID,
        self::DB_FILED_PARENT_ID,
        self::DB_FILED_LEVEL,
        self::DB_FILED_SORT,
        self::DB_FILED_NAME,
        self::DB_FILED_TYPE,
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