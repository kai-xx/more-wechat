<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:39
 */

namespace App\Endpoints\Fans;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatFans;

/**
 * 编辑公众号粉丝
 * Class UpdateFans
 * @package App\Endpoints\Wechat
 */
class UpdateFans extends BaseEndpoint
{
    /**
     * @return WechatFans WechatFans
     */
    public function fans() {
        return new WechatFans();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateFans(int $id)
    {
        $this->validate($this->request,$this->rules());

        $fans = $this->fans()->find($id);
        if ($fans instanceof WechatFans) {

            if (!$this->verifyOperationRightsByOaWechatId($fans->{WechatFans::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, [],'非法操作');

            $fans = $this->setAttribute($fans);
            if ($fans->save())
                return $this->resultForApi(200, $fans,'');
            else
                return  $this->resultForApi(400, [],'更改失败');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }

    /**
     * 验证规则
     * @return array
     */
    private function rules() {

        return [

        ];
    }
}