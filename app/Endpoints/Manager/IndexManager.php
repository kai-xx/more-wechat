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

        $phone = $this->request->input(Manager::DB_FILED_PHONE);
        $name = $this->request->input(Manager::DB_FILED_NAME);

        $type = $this->request->input(Manager::DB_FILED_TYPE);
        $state = $this->request->input(Manager::DB_FILED_STATE);

        if ($phone) $filters[] = [Manager::DB_FILED_PHONE, "like", "%". $phone . "%"];
        if ($name) $filters[] = [Manager::DB_FILED_NAME, "like", "%". $name . "%"];
        if ($type) $filters[] = [Manager::DB_FILED_TYPE, "=", $type];
        if ($state) $filters[] = [Manager::DB_FILED_STATE, "=", $state];
        app('db')->connection()->enableQueryLog();
        $manager = Manager::where($filters)
            ->whereRaw("find_in_set(?,". Manager::DB_FILED_LEVEL_MAP .")",[Auth::user()->getKey()])
            ->offset($limit)
            ->limit($offset)
            ->get();
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

        return $manager;
    }
}