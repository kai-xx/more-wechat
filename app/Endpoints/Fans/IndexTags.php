<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\Fans;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatFansTag;
use App\Models\WechatMessage;

/**
 * 标签列表
 * Class IndexFans
 * @package App\Endpoints\Fans
 */
class IndexTags extends BaseEndpoint
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

        $keyword = $this->request->input(static::ARGUMENT_KEYWORD);

        $state = $this->request->input(WechatFansTag::DB_FILED_STATE);
        $messageId = $this->request->input('message_id');
        if (!empty($messageId)) {
            $message = WechatMessage::find($messageId);
            if (!($message instanceof WechatMessage)) return $this->resultForApiWithPagination(400, [], 0, $limit,$offset, "消息不存在");
            $wechatId = $message->{WechatMessage::DB_FILED_OA_WECHAT_ID};

        }else{
            $wechatId = $this->request->input(WechatFansTag::DB_FILED_OA_WECHAT_ID);
        }
        $raw = "1=1";
        $budding = [];
        if ($keyword) {
            $raw .= " and (
            " . WechatFansTag::DB_FILED_TAG_NAME ." like ? )";
            $budding = array_merge($budding,[
                "%$keyword%",
            ]);
        }
        if ($state) $filters[] = [WechatFansTag::DB_FILED_STATE, "=", $state];
        if ($wechatId) $filters[] = [WechatFansTag::DB_FILED_OA_WECHAT_ID, "=", $wechatId];
        $fans = WechatFansTag::where($filters)
            ->whereRaw($raw,$budding)
            ->offset($offset)
            ->limit($limit)
            ->get();
        $count = WechatFansTag::where($filters)
            ->whereRaw($raw,$budding)
            ->count();
        if ($fans == false)
            return $this->resultForApiWithPagination(400, $fans, $count, $limit,$offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $fans, $count, $limit, $offset);
    }
}