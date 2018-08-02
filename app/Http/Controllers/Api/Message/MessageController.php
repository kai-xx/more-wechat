<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 16:34
 */

namespace App\Http\Controllers\Api\Message;


use App\Endpoints\Message\DeleteMessage;
use App\Endpoints\Message\IndexMessage;
use App\Endpoints\Message\ShowMessage;
use App\Endpoints\Message\StoreMessage;
use App\Endpoints\Message\UpdateMessage;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

/**
 * Class MessageController
 * @package App\Http\Controllers\Api\Message
 */
class MessageController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        return (new IndexMessage($request))->index();
    }


    /**
     * @param Request $request
     * @return \App\Models\WechatMessage|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        return (new StoreMessage($request))->storeMessage();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        return (new UpdateMessage($request))->updateMessage($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        return (new ShowMessage($request))->showMessage($id);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request, $id)
    {
        return (new DeleteMessage($request))->delete($id);
    }
}