<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\Wechat;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\OaWechat;
use Illuminate\Support\Facades\Auth;

/**
 * 公众号列表
 * Class IndexWechat
 * @package App\Endpoints\Wechat
 */
class IndexWechat extends BaseEndpoint
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

        $type = $this->request->input(OaWechat::DB_FILED_TYPE);
        $state = $this->request->input(OaWechat::DB_FILED_STATE);
        $wechatIds = $this->request->input('wechatIds');
        if (empty($wechatIds)) {
            return $this->resultForApiWithPagination(200, [], 0, $limit, $offset);
        }
        $raw = "1=1";
        $budding = [];
        if ($keyword) {
            $raw .= " and (
            " . OaWechat::DB_FILED_LINKMAN ." like ? OR 
            " . OaWechat::DB_FILED_PHONE ." like ? OR 
            " . OaWechat::DB_FILED_NAME ." like ?)";
            $budding = array_merge($budding,[
                "%$keyword%",
                "%$keyword%",
                "%$keyword%"
            ]);
        }
        if ($type) $filters[] = [OaWechat::DB_FILED_TYPE, "=", $type];
        if ($state) $filters[] = [OaWechat::DB_FILED_STATE, "=", $state];
        $wechat = OaWechat::where($filters)
            ->whereIn(OaWechat::DB_FILED_ID, $wechatIds)
            ->whereRaw($raw, $budding)
            ->offset($offset)
            ->limit($limit)
            ->get();
        $count = OaWechat::where($filters)
            ->whereRaw($raw, $budding)
            ->count();
        if ($wechat == false)
            return $this->resultForApiWithPagination(400, $wechat, $count, $limit, $offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $wechat, $count, $limit, $offset);
    }
}