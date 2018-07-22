<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:03
 */

namespace App\Http\Endpoints\Base;


use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class BaseEndpoint extends Controller
{
    const ARGUMENT_LIMIT = 'limit'; // 分页
    const ARGUMENT_OFFSET = 'offset'; // 跳过数目

    const ARGUMENT_ORDER = 'order';
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    public function setAttribute(Model $model)
    {
        foreach ($model->getFillable() as $item) {
            if ($this->request->has($item)) {
                $model->setAttribute($item, $this->request->input($item));
            }
        }
        return $model;
    }
}