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

        $raw = "find_in_set(?,". OaWechat::DB_FILED_LEVEL_MAP .")";
        $budding = [Auth::user()->getKey()];
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
        app('db')->connection()->enableQueryLog();
        $Wechat = OaWechat::where($filters)
            ->whereRaw($raw, $budding)
            ->offset($limit)
            ->limit($offset)
            ->get();
        $count = OaWechat::where($filters)
            ->whereRaw($raw, $budding)
            ->count();
        $sql = app('db')->getQueryLog();
        $query = "";
        foreach ($sql as $item) {
            $query = $item['query'];
            foreach ($item['bindings'] as $replace){
                $value = is_numeric($replace) ? $replace : "'".$replace."'";
                $query = preg_replace('/\?/', $value, $query, 1);
            }
        }
        var_dump($query);
        if ($Wechat == false)
            return $this->resultForApiWithPagination(400, $Wechat, $count, $offset, $limit, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $Wechat, $count, $offset, $limit);
    }
}