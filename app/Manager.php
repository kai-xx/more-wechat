<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{

    const TABLE_NAME = 'mb_manager';
    protected $table = self::TABLE_NAME;

    const DB_FILED_ID                   = 'id';
    const DB_FILED_NAME                 = 'name';
    const DB_FILED_LOGIN_NAME           = 'login_name';
    const DB_FILED_PASSWORD             = 'password';
    const DB_FILED_TYPE                 = 'type';
    const DB_FILED_STATE                = 'state';
    const DB_FILED_OA_WECHAT_ID         = 'oa_wechat_id';
    const DB_FILED_PARENT_ID            = 'parent_id';
    const DB_FILED_PHONE                = 'phone';
    const DB_FILED_EMAIL                = 'email';
    const DB_FILED_QQ                   = 'qq';
    const DB_FILED_WECHAT_NUMBER        = 'wechat_number';
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
        self::DB_FILED_NAME,
        self::DB_FILED_LOGIN_NAME,
        self::DB_FILED_TYPE,
        self::DB_FILED_STATE,
        self::DB_FILED_OA_WECHAT_ID,
        self::DB_FILED_PARENT_ID,
        self::DB_FILED_PHONE,
        self::DB_FILED_EMAIL,
        self::DB_FILED_QQ,
        self::DB_FILED_WECHAT_NUMBER,
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
        self::DB_FILED_PASSWORD,
    ];
}