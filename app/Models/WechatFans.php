<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WechatFans extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_fans';
    protected $table = self::TABLE_NAME;

    const DB_FILED_ID                   = 'id';
    const DB_FILED_OA_WECHAT_ID         = 'oa_wechat_id';
    const DB_FILED_OPEN_ID              = 'open_id';
    const DB_FILED_NIKE                 = 'nike';
    const DB_FILED_SEX                  = 'sex';
    const DB_FILED_HEAD_IMG             = 'head_img';
    const DB_FILED_CITY                 = 'city';
    const DB_FILED_ADDRESS              = 'address';
    const DB_FILED_PHONE                = 'phone';



    const DB_FILED_CREATED_AT           = 'created_at';
    const DB_FILED_UPDATE_AT            = 'update_at';
    const DB_FILED_DELETE_AT            = 'delete_at';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_OA_WECHAT_ID,
        self::DB_FILED_OPEN_ID,
        self::DB_FILED_NIKE,
        self::DB_FILED_SEX,
        self::DB_FILED_HEAD_IMG,
        self::DB_FILED_CITY,
        self::DB_FILED_ADDRESS,
        self::DB_FILED_PHONE,
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