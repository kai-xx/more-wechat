<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:03
 */

namespace App\Http\Endpoints\Base;


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

}