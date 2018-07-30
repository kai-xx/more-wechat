<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:47
 */

namespace App\Endpoints\Manager;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;

/**
 * 用户列表
 * Class IndexManager
 * @package App\Endpoints\Manager
 */
class IndexManager extends BaseEndpoint
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

        $type = $this->request->input(Manager::DB_FILED_TYPE);
        $state = $this->request->input(Manager::DB_FILED_STATE);
        $raw = "find_in_set(?,". Manager::DB_FILED_LEVEL_MAP .")";
        $budding = [Auth::user()->getKey()];
        if ($keyword) {
            $raw .= " and (
            " . Manager::DB_FILED_PHONE ." like ? OR 
            " . Manager::DB_FILED_NAME ." like ?)";
            $budding = array_merge($budding,[
                "%$keyword%",
                "%$keyword%"
            ]);
        }
        if ($type) $filters[] = [Manager::DB_FILED_TYPE, "=", $type];
        if ($state) $filters[] = [Manager::DB_FILED_STATE, "=", $state];
        app('db')->connection()->enableQueryLog();
        $manager = Manager::where($filters)
            ->whereRaw($raw,$budding)
            ->offset($limit)
            ->limit($offset)
            ->get();
        $count = Manager::where($filters)
            ->whereRaw($raw,$budding)
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
//        echo json_encode($query, JSON_UNESCAPED_UNICODE);
        var_dump($query);
        if ($manager == false)
            return $this->resultForApiWithPagination(400, $manager, $count, $offset, $limit, "查询失败");
        else
            return $this->resultForApiWithPagination(200, $manager, $count, $offset, $limit);
    }
}