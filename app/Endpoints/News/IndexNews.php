<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatGraphic;
use Illuminate\Support\Facades\Auth;

/**
 * 图文列表
 * Class IndexNews
 * @package App\Endpoints\News
 */
class IndexNews extends BaseEndpoint
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

        $type = $this->request->input(WechatGraphic::DB_FILED_TYPE);
        $state = $this->request->input(WechatGraphic::DB_FILED_STATE);
        $raw = "1=1";
        $budding = [];
        if ($keyword) {
            $raw .= " and (
            " . WechatGraphic::DB_FILED_TITLE ." like ? )";
            $budding = array_merge($budding,[
                "%$keyword%",
            ]);
        }
        if ($type) $filters[] = [WechatGraphic::DB_FILED_TYPE, "=", $type];
        if ($state) $filters[] = [WechatGraphic::DB_FILED_STATE, "=", $state];
        $news = WechatGraphic::where($filters)
            ->whereRaw($raw,$budding)
            ->offset($offset)
            ->limit($limit)
            ->get();
        $count = WechatGraphic::where($filters)
            ->whereRaw($raw,$budding)
            ->count();
        if ($news == false)
            return $this->resultForApiWithPagination(400, $news, $count, $limit,$offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $news, $count, $limit, $offset);
    }
}