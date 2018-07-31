<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 16:34
 */

namespace App\Http\Controllers\Api\Wechat;


use App\Endpoints\Wechat\DeleteWechat;
use App\Endpoints\Wechat\IndexWechat;
use App\Endpoints\Wechat\ShowWechat;
use App\Endpoints\Wechat\StoreWechat;
use App\Endpoints\Wechat\UpdateWechat;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

/**
 * Class WechatController
 * @package App\Http\Controllers\Api\Wechat
 */
class WechatController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        return (new IndexWechat($request))->index();
    }


    /**
     * @param Request $request
     * @return \App\Models\OaWechat|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        return (new StoreWechat($request))->storeWechat();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        return (new UpdateWechat($request))->updateWechat($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        return (new ShowWechat($request))->showWechat($id);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request, $id)
    {
        return (new DeleteWechat($request))->delete($id);
    }

}