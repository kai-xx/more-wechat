<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 10:08
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OaWechat extends Model
{
    const TABLE_NAME = 'mb_oa_wechat';
    protected $table = self::TABLE_NAME;

    const DB_FILED_ID                   = 'id';
    const DB_FILED_TOKEN                = 'token';
    const DB_FILED_LINKMAN              = 'linkman';
    const DB_FILED_PHONE                = 'phone';
    const DB_FILED_ADDRESS              = 'address';
    const DB_FILED_NAME                 = 'name';
    const DB_FILED_ORIGINAL_ID          = 'original_id';
    const DB_FILED_WECHAT_NUMBER        = 'wechat_number';
    const DB_FILED_APP_ID               = 'app_id';
    const DB_FILED_APP_SECRET           = 'app_secret';
    const DB_FILED_TYPE                 = 'type';
    const DB_FILED_IMAGE                = 'image';
    const DB_FILED_STATE                = 'state';
    const DB_FILED_AUTH_PATH            = 'auth_path';
    const DB_FILED_MANAGER_ID           = 'manager_id';
    const DB_FILED_CREATED_AT           = 'created_at';
    const DB_FILED_UPDATE_AT            = 'update_at';
    const DB_FILED_DELETE_AT            = 'delete_at';

    const STATE_OPEN                    = 1; // 开启
    const STATE_CLOSE                   = 2; // 关闭

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_MANAGER_ID,
        self::DB_FILED_TOKEN,
        self::DB_FILED_NAME,
        self::DB_FILED_ORIGINAL_ID,
        self::DB_FILED_WECHAT_NUMBER,
        self::DB_FILED_APP_ID,
        self::DB_FILED_APP_SECRET,
        self::DB_FILED_TYPE,
        self::DB_FILED_IMAGE,
        self::DB_FILED_STATE,
        self::DB_FILED_AUTH_PATH,
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