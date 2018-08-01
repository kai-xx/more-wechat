<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:39
 */

namespace App\Endpoints\Wechat;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;
use App\Models\OaWechat;

/**
 * 编辑公众号
 * Class UpdateWechat
 * @package App\Endpoints\Wechat
 */
class UpdateWechat extends BaseEndpoint
{
    /**
     * @return OaWechat OaWechat
     */
    public function oaWechat() {
        return new OaWechat();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateWechat(int $id)
    {
        $this->validate($this->request,$this->rules());

        $wechat = $this->oaWechat()->find($id);
        if ($wechat instanceof OaWechat) {
            $manager = Manager::find($wechat->{OaWechat::DB_FILED_MANAGER_ID});
            if (!$this->verifyOperationPermissions($manager))
                return  $this->resultForApi(400, [],'非法操作');

            $wechat = $this->setAttribute($wechat);
            if ($wechat->save())
                return  $this->resultForApi(200, $wechat,'');
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