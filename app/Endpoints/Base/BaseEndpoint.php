<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:03
 */

namespace App\Http\Endpoints\Base;

use Log;
use App\Http\Controllers\Controller;
use App\Models\Auth;
use App\Models\Manager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class BaseEndpoint
 * @package App\Http\Endpoints\Base
 */
class BaseEndpoint extends Controller
{
    /**
     *
     */
    const ARGUMENT_LIMIT = 'limit'; // 分页
    /**
     *
     */
    const ARGUMENT_OFFSET = 'offset'; // 跳过数目

    const ARGUMENT_ORDER = 'order';
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $token = $this->request->header("Authorization");
        Log::info("接收到数据为："  , array_merge(['token'=>$token],$this->request->all()));
    }

    /**
     * @param Model $model
     * @return Model
     */
    protected function setAttribute(Model $model)
    {
        foreach ($model->getFillable() as $item) {
            if ($this->request->has($item)) {
                $model->setAttribute($item, $this->request->input($item));
            }
        }
        return $model;
    }

    /**
     * @param Manager $manager
     * @return bool
     */
    protected function verifyOperationPermissions(Manager $manager) {
        return in_array(Auth::user()->getKey(), explode(',', $manager->{Manager::DB_FILED_LEVEL_MAP}));
    }

    protected $total = 0;
    protected $perPage = 20;
    protected $from = 0;
    protected $data = [];
    protected $error = "";

    /**
     * @param int $code
     * @param $data
     * @param $total
     * @param $perPage
     * @param $from
     * @param $error
     * @return $this
     */
    protected function resultForApiWithPagination(int $code, $data ,int $total,int $perPage,int $from, $error){
        $this->total = $total;
        $this->perPage = $perPage;
        $this->from = $from;
        $this->data = $data;
        if ($code <> 200) $this->error = $error;
        return $this;
    }

    /**
     * @param int $code
     * @param $data
     * @param $error
     * @return $this
     */
    protected function resultForApi(int $code, $data, $error){
        $this->data = $data;
        if ($code <> 200) $this->error = $error;
        return $this;
    }
    protected function printSQL($callback) {
        app('db')->connection()->enableQueryLog();
        $callback;
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
    }
}