<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatMessage;
use Illuminate\Support\Facades\Auth;

/**
 * 消息列表
 * Class IndexMessage
 * @package App\Endpoints\Message
 */
class IndexMessage extends BaseEndpoint
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

        $type = $this->request->input(WechatMessage::DB_FILED_TYPE);
        $state = $this->request->input(WechatMessage::DB_FILED_STATE);
        $wechatId = $this->request->input(WechatMessage::DB_FILED_OA_WECHAT_ID);

        $raw = "1=1";
        $budding = [];
        if ($keyword) {
            $raw .= " and (
            " . WechatMessage::DB_FILED_TITLE ." like ?)";
            $budding = array_merge($budding,[
                "%$keyword%",
            ]);
        }
        if ($type) $filters[] = [WechatMessage::DB_FILED_TYPE, "=", $type];
        if ($state) $filters[] = [WechatMessage::DB_FILED_STATE, "=", $state];
        if ($wechatId) $filters[] = [WechatMessage::DB_FILED_OA_WECHAT_ID, "=", $wechatId];
        $wechat = WechatMessage::where($filters)
            ->whereRaw($raw, $budding)
            ->offset($offset)
            ->limit($limit)
            ->get();
        $count = WechatMessage::where($filters)
            ->whereRaw($raw, $budding)
            ->count();
        if ($wechat == false)
            return $this->resultForApiWithPagination(400, $wechat, $count, $limit, $offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $wechat, $count, $limit, $offset);
    }
}