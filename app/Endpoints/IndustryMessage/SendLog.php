<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\IndustryMessage;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\IndustryMessageSendLog;
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

        $status = $this->request->input(IndustryMessageSendLog::DB_FILED_STATUS);
        $messageId = $this->request->input('message_id');
        if (empty($messageId)) return $this->resultForApiWithPagination(200, [], 0, $limit, $offset);
        if ($status) $filters[] = [IndustryMessageSendLog::DB_FILED_STATUS, "=", $status];
        if ($messageId) $filters[] = [IndustryMessageSendLog::DB_FILED_INDUSTRY_MESSAGE_ID, "=", $messageId];
        $wechat = IndustryMessageSendLog::where($filters)
            ->leftJoin(
                WechatFans::TABLE_NAME,
                IndustryMessageSendLog::DB_FILED_FANS_ID, "=",
                WechatFans::TABLE_NAME . "." . WechatFans::DB_FILED_ID
            )
            ->select(
                WechatFans::DB_FILED_NIKE,
                WechatFans::DB_FILED_HEAD_IMG,
                WechatFans::DB_FILED_SEX,
                IndustryMessageSendLog::TABLE_NAME . "." . IndustryMessageSendLog::CREATED_AT,
                IndustryMessageSendLog::DB_FILED_REASON,
                IndustryMessageSendLog::DB_FILED_FANS_ID,
                IndustryMessageSendLog::DB_FILED_INDUSTRY_MESSAGE_ID,
                IndustryMessageSendLog::DB_FILED_STATUS,
                IndustryMessageSendLog::TABLE_NAME . "." . IndustryMessageSendLog::DB_FILED_ID
                )
            ->offset($offset)
            ->limit($limit)
            ->orderBy(IndustryMessageSendLog::DB_FILED_ID, 'desc')
            ->get();
        $count = IndustryMessageSendLog::where($filters)
            ->count();
        if ($wechat == false)
            return $this->resultForApiWithPagination(400, $wechat, $count, $limit, $offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $wechat, $count, $limit, $offset);
    }
}