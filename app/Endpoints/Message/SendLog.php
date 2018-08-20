<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\SendMessageLog;
use App\Models\WechatFans;

/**
 * 消息日志
 * Class SendLog
 * @package App\Endpoints\Message
 */
class SendLog extends BaseEndpoint
{
    /**
     * @return mixed
     */
    public function index()
    {
        $filters = [];
        $limit = $this->request->input(static::ARGUMENT_LIMIT);
        $offset = $this->request->input(static::ARGUMENT_OFFSET);
        $order = $this->request->input(static::ARGUMENT_ORDER);

        $status = $this->request->input(SendMessageLog::DB_FILED_STATUS);
        $messageId = $this->request->input(SendMessageLog::DB_FILED_MESSAGE_ID);

        if ($status) $filters[] = [SendMessageLog::DB_FILED_STATUS, "=", $status];
        if ($messageId) $filters[] = [SendMessageLog::DB_FILED_MESSAGE_ID, "=", $messageId];
        $wechat = SendMessageLog::where($filters)
            ->leftJoin(
                WechatFans::TABLE_NAME,
                SendMessageLog::DB_FILED_FANS_ID, "=",
                WechatFans::TABLE_NAME . "." . WechatFans::DB_FILED_ID
            )
            ->select(
                WechatFans::DB_FILED_NIKE,
                WechatFans::DB_FILED_HEAD_IMG,
                WechatFans::DB_FILED_SEX,
                SendMessageLog::TABLE_NAME . "." . SendMessageLog::CREATED_AT,
                SendMessageLog::DB_FILED_REASON,
                SendMessageLog::DB_FILED_MESSAGE_ID,
                SendMessageLog::DB_FILED_STATUS,
                SendMessageLog::TABLE_NAME . "." . SendMessageLog::DB_FILED_ID
                )
            ->offset($offset)
            ->limit($limit)
            ->orderBy(SendMessageLog::DB_FILED_ID, 'desc')
            ->get();
        $count = SendMessageLog::where($filters)
            ->count();
        if ($wechat == false)
            return $this->resultForApiWithPagination(400, $wechat, $count, $limit, $offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $wechat, $count, $limit, $offset);
    }
}