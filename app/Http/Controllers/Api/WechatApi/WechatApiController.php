<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/4
 * Time: 下午9:11
 */

namespace App\Http\Controllers\Api\WechatApi;


use App\Endpoints\WechatApi\SendMessage;
use App\Endpoints\WechatApi\UpdateFans;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

class WechatApiController extends BaseController
{
    public function updateFans(Request $request)
    {
        return (new UpdateFans($request))->updateFans();
    }

    public function sendMessage(Request $request)
    {
        return (new SendMessage($request))->sendMessage();
    }
}