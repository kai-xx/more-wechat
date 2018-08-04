<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\Fans;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatFans;
use Illuminate\Support\Facades\Auth;

/**
 * 粉丝列表
 * Class IndexFans
 * @package App\Endpoints\Fans
 */
class IndexFans extends BaseEndpoint
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

        $state = $this->request->input(WechatFans::DB_FILED_STATE);
        $wechatId = $this->request->input(WechatFans::DB_FILED_OA_WECHAT_ID);
        $raw = "1=1";
        $budding = [];
        if ($keyword) {
            $raw .= " and (
            " . WechatFans::DB_FILED_NIKE ." like ? )";
            $budding = array_merge($budding,[
                "%$keyword%",
            ]);
        }
        if ($state) $filters[] = [WechatFans::DB_FILED_STATE, "=", $state];
        if ($wechatId) $filters[] = [WechatFans::DB_FILED_OA_WECHAT_ID, "=", $wechatId];
        $fans = WechatFans::where($filters)
            ->whereRaw($raw,$budding)
            ->offset($offset)
            ->limit($limit)
            ->get();
        $count = WechatFans::where($filters)
            ->whereRaw($raw,$budding)
            ->count();
        if ($fans == false)
            return $this->resultForApiWithPagination(400, $fans, $count, $limit,$offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $fans, $count, $limit, $offset);
    }
}