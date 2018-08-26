<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\IndustryMessage;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Industry;
use App\Models\IndustryMessage;
use App\Models\WechatMessage;


/**
 * 模版列表
 * Class IndexIndustry
 * @package App\Endpoints\IndustryMessage
 */
class IndexIndustry extends BaseEndpoint
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

        $state = $this->request->input(Industry::DB_FILED_STATE);
        $wechatId = $this->request->input(Industry::DB_FILED_OA_WECHAT_ID);
        $raw = "1=1";
        $budding = [];
        if ($keyword) {
            $raw .= " and (
            " . Industry::DB_FILED_TITLE ." like ? )";
            $budding = array_merge($budding,[
                "%$keyword%",
            ]);
        }
        if ($state) $filters[] = [Industry::DB_FILED_STATE, "=", $state];
        if ($wechatId) $filters[] = [Industry::DB_FILED_OA_WECHAT_ID, "=", $wechatId];
        $industry = Industry::where($filters)
            ->whereRaw($raw,$budding)
            ->offset($offset)
            ->limit($limit)
            ->get();
       $industry->each(function (&$item){
           $messgeInfo = IndustryMessage::where(IndustryMessage::DB_FILED_INDUSTRY_ID, $item->getKey())->first();
           if ($messgeInfo instanceof IndustryMessage) {
               $info = $messgeInfo->getKey();
           }else {
               $info = 0;
           }
           $item->setAttribute('industry_message_id', $info);
       });
        $count = Industry::where($filters)
            ->whereRaw($raw,$budding)
            ->count();
        if ($industry == false)
            return $this->resultForApiWithPagination(400, $industry, $count, $limit,$offset, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $industry, $count, $limit, $offset);
    }
}