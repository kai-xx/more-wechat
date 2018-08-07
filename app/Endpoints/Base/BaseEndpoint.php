<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:03
 */

namespace App\Http\Endpoints\Base;

use App\Models\OaWechat;
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
        app('log')->info("接收到数据为："  , array_merge([
            'token'=>$token
        ],$this->request->all()), compact('time'));
    }

    /**
     * @param Model $model
     * @return Model
     */
    protected function setAttribute(Model $model)
    {
        foreach ($model->getFillable() as $item) {
            if ($this->request->has($item)) {
                if ($item == "created_at" || $item == "updated_at" || $item == "deleted_at") continue;
                $model->setAttribute($item, $this->request->input($item));
            }
        }
        return $model;
    }

    /**
     * 根据用户信息验证是否有权限操作
     * @param Manager $manager
     * @return bool
     */
    protected function verifyOperationPermissions(Manager $manager) {
        if ($manager->{Manager::DB_FILED_STATE} == Manager::STATE_CLOSE)
            return false;
        return in_array(Auth::user()->getKey(), explode(',', $manager->{Manager::DB_FILED_LEVEL_MAP}));
    }

    /**
     * 根据公众号ID验证是否有权限操作
     * @param int $wechatId
     * @return bool
     */
    protected function verifyOperationRightsByOaWechatId(int $wechatId) {
        $wechat = new OaWechat();
        $wechatInfo = $wechat->find($wechatId);
        if (!($wechatInfo instanceof OaWechat)) return false;
        $manager = new Manager();
        $managerInfo = $manager->find($wechatInfo->{OaWechat::DB_FILED_MANAGER_ID});
        if (!($managerInfo instanceof Manager)) return false;
        return $this->verifyOperationPermissions($managerInfo);
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
        app('log')->info("返回数据为："  , $class->toArray(), compact('time'));
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
        app('log')->info("返回数据为："  , $class->toArray(), compact('time'));
        return response()->json($class, $status);
    }

    protected function absolutePath($path) {
        if (strpos($path, "http://") === false || strpos($path, "https://") === false ) {
            return env('APP_URL') . trim($path,'.');
        }
        return $path;
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