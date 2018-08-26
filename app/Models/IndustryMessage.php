<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/26
 * Time: 上午11:45
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 模版消息
 * Class Industry
 * @package App\Models
 */
class IndustryMessage extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_industry_message';
    protected $table = self::TABLE_NAME;

    const DB_FILED_ID                   = 'id';
    const DB_FILED_INDUSTRY_ID          = 'industry_id';
    const DB_FILED_MANAGER_ID           = 'manager_id';
    const DB_FILED_APPLET_APP_ID        = 'applet_app_id';
    const DB_FILED_APPLET_URI           = 'applet_uri';
    const DB_FILED_APPLET_PATH          = 'applet_path';
    const DB_FILED_CONTENT              = 'content';
    const DB_FILED_REMARK               = 'remark';
    const DB_FILED_STATE                = 'state';
    const DB_FILED_TYPE                 = 'type';
    const DB_FILED_SEND_AT              = 'send_at';
    const DB_FILED_CREATED_AT           = 'created_at';
    const DB_FILED_UPDATE_AT            = 'update_at';
    const DB_FILED_DELETE_AT            = 'delete_at';

    const TYPE_OTHER                    = 1;
    const TYPE_TIMING                   = 2;

    const STATE_OPEN                    = 1; // 开启
    const STATE_CLOSE                   = 2; // 关闭
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_INDUSTRY_ID,
        self::DB_FILED_APPLET_APP_ID,
        self::DB_FILED_APPLET_URI,
        self::DB_FILED_APPLET_PATH,
        self::DB_FILED_CONTENT,
        self::DB_FILED_REMARK,
        self::DB_FILED_TYPE,
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