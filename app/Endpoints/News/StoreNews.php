<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 17:33
 */

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\OaWechat;
use App\Models\WechatGraphic;
use Illuminate\Support\Facades\Auth;

/**
 * 添加图文
 * Class StoreNews
 * @package App\Endpoints\News
 */
class StoreNews extends BaseEndpoint
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeNews() {
        $this->validate($this->request,$this->rules());
        $fans = new WechatGraphic();
        $fans = $this->setAttribute($fans);

        if (!$this->verifyOperationRightsByOaWechatId($fans->{WechatGraphic::DB_FILED_OA_WECHAT_ID}))
            return  $this->resultForApi(400, '非法操作');


        $fans->setAttribute(WechatGraphic::DB_FILED_STATE, WechatGraphic::STATE_OPEN);
        $fans->setAttribute(WechatGraphic::DB_FILED_MANAGER_ID, Auth::user()->getKey());
        $fans->save();
        if ($fans)
            return $this->resultForApi(200, $fans);
        else
            return $this->resultForApi(400, [], "操作失败");


    }
    /**
     * 验证规则
     * @return array
     */
    public function rules() {

        return [

        ];
    }
}