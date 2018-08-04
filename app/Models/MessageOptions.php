<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageOptions extends Model
{
    use SoftDeletes;
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    const TABLE_NAME = 'mb_oa_wechat_message_options';
    protected $table = self::TABLE_NAME;



    const DB_FILED_ID                  = 'id';
    const DB_FILED_MESSAGE_ID          = 'message_id';
    const DB_FILED_RESOURCE_ID         = 'resource_id';
    const DB_FILED_MANAGER_ID          = 'manager_id';
    const DB_FILED_STATE               = 'state';
    const DB_FILED_CREATED_AT          = 'created_at';
    const DB_FILED_UPDATE_AT           = 'update_at';
    const DB_FILED_DELETE_AT           = 'delete_at';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::DB_FILED_ID,
        self::DB_FILED_MESSAGE_ID,
        self::DB_FILED_MANAGER_ID,
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