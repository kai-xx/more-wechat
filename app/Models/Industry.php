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
class Industry extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_industry';
    protected $table = self::TABLE_NAME;

    const DB_FILED_ID                   = 'id';
    const DB_FILED_OA_WECHAT_ID         = 'oa_wechat_id';
    const DB_FILED_TEMPLATE_ID          = 'template_id';
    const DB_FILED_TITLE                = 'title';
    const DB_FILED_PRIMARY_INDUSTRY     = 'primary_industry';
    const DB_FILED_DEPUTY_INDUSTRY      = 'deputy_industry';
    const DB_FILED_CONTENT              = 'content';
    const DB_FILED_EXAMPLE              = 'example';
    const DB_FILED_REMARK               = 'remark';
    const DB_FILED_STATE                = 'state';
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
        self::DB_FILED_TEMPLATE_ID,
        self::DB_FILED_TITLE,
        self::DB_FILED_PRIMARY_INDUSTRY,
        self::DB_FILED_DEPUTY_INDUSTRY,
        self::DB_FILED_CONTENT,
        self::DB_FILED_EXAMPLE,
        self::DB_FILED_REMARK,
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