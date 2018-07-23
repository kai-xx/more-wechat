<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:03
 */

namespace App\Http\Endpoints\Base;

use Log;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
    * 关键词
    */
    const ARGUMENT_KEYWORD = 'keyword';
    /**
     * 分页
     */
    const ARGUMENT_LIMIT = 'limit'; //
    /**
     * 跳过数目
     */
    const ARGUMENT_OFFSET = 'offset'; //

    /**
     * 排序
     */
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

    const RESULT_TOTAL      = 'total';
    const RESULT_PER_PAGE   = 'perPage';
    const RESULT_FROM       = 'from';
    const RESULT_DATA       = 'data';
    const RESULT_ERROR      = 'error';


    /**
     * @param int $status
     * @param $data
     * @param int $total
     * @param int $perPage
     * @param int $from
     * @param string $error
     * @return \Illuminate\Http\JsonResponse
     */
    protected function resultForApiWithPagination(int $status = 200, $data , int $total = 0, int $perPage = 20, int $from = 0, $error = ""){
        $class = new Collection;
        $class->put(static::RESULT_TOTAL, $total);
        $class->put(static::RESULT_PER_PAGE, $perPage);
        $class->put(static::RESULT_FROM, $from);
        $class->put(static::RESULT_DATA, $data);
        $class->put(static::RESULT_ERROR, $error);

        return response()->json($class, $status);
    }


    /**
     * @param int $status
     * @param $data
     * @param string $error
     * @return \Illuminate\Http\JsonResponse
     */
    protected function resultForApi(int $status = 200, $data, $error = ""){
        $class = new Collection;
        $class->put(static::RESULT_DATA, $data);
        $class->put(static::RESULT_ERROR, $error);
        return response()->json($class, $status);
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