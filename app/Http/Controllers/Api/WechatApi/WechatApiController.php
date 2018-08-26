<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/4
 * Time: 下午9:11
 */

namespace App\Http\Controllers\Api\WechatApi;


use App\Endpoints\WechatApi\SendIndustryMessage;
use App\Endpoints\WechatApi\SendMessage;
use App\Endpoints\WechatApi\UpdateFans;
use App\Endpoints\WechatApi\UpdateIndustry;
use App\Endpoints\WechatApi\UpdateTags;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

/**
 * Class WechatApiController
 * @package App\Http\Controllers\Api\WechatApi
 */
class WechatApiController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function updateFans(Request $request)
    {
        return (new UpdateFans($request))->updateFans();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTags(Request $request)
    {
        return (new UpdateTags($request))->updateTags();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        return (new SendMessage($request))->sendMessage();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateIndustry(Request $request)
    {
        return (new UpdateIndustry($request))->updateIndustry();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendIndustryMessage(Request $request)
    {
        return (new SendIndustryMessage($request))->sendMessage();
    }
}