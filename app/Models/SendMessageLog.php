<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/15
 * Time: 下午11:02
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SendMessageLog extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_send_message_log';
    protected $table = self::TABLE_NAME;

    const DB_FILED_ID                   = 'id';
    const DB_FILED_FANS_ID              = 'fans_id';
    const DB_FILED_MESSAGE_ID           = 'message_id';
    const DB_FILED_STATE                = 'state';
    const DB_FILED_STATUS               = 'status';
    const DB_FILED_REASON               = 'reason';


    const DB_FILED_CREATED_AT           = 'created_at';
    const DB_FILED_UPDATE_AT            = 'update_at';
    const DB_FILED_DELETE_AT            = 'delete_at';

    const STATE_OPEN                    = 1; // 开启
    const STATE_CLOSE                   = 2; // 关闭

    const STATUS_SUCCESS                = 1;
    const STATUS_FALSE                  = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_FANS_ID,
        self::DB_FILED_MESSAGE_ID,
        self::DB_FILED_STATUS,
        self::DB_FILED_STATE,
        self::DB_FILED_REASON,
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