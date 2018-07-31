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
    const DB_FILED_COUNTRY              = 'country';
    const DB_FILED_PROVINCE             = 'province';
    const DB_FILED_SUBSCRIBE_TIME       = 'subscribe_time';
    const DB_FILED_GROUPID              = 'groupid';
    const DB_FILED_REMARK               = 'remark';
    const DB_FILED_SUBSCRIBE_SCENE      = 'subscribe_scene';//返回用户关注的渠道来源，ADD_SCENE_SEARCH 公众号搜索，ADD_SCENE_ACCOUNT_MIGRATION 公众号迁移，ADD_SCENE_PROFILE_CARD 名片分享，ADD_SCENE_QR_CODE 扫描二维码，ADD_SCENEPROFILE LINK 图文页内名称点击，ADD_SCENE_PROFILE_ITEM 图文页右上角菜单，ADD_SCENE_PAID 支付后关注，ADD_SCENE_OTHERS 其他
    const DB_FILED_LATITUDE             = 'latitude'; //纬度
    const DB_FILED_LONGITUDE            = 'longitude'; // 经度
    const DB_FILED_PRECISION            = 'precision'; // 精度
    const DB_FILED_UNIONID              = 'unionid'; //
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
        self::DB_FILED_COUNTRY,
        self::DB_FILED_PROVINCE,
        self::DB_FILED_SUBSCRIBE_TIME,
        self::DB_FILED_GROUPID,
        self::DB_FILED_REMARK,
        self::DB_FILED_SUBSCRIBE_SCENE,
        self::DB_FILED_LATITUDE,
        self::DB_FILED_LONGITUDE,
        self::DB_FILED_PRECISION,
        self::DB_FILED_UNIONID,
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