<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:41
 */

namespace App\Endpoints\Wechat;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\OaWechat;

/**
 * 删除公众号
 * Class DeleteWechat
 * @package App\Endpoints\Wechat
 */
class DeleteWechat extends BaseEndpoint
{
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(int $id){
        $Wechat = (new OaWechat())->find($id);
        if ($Wechat instanceof OaWechat) {
            if (!$this->verifyOperationPermissions($Wechat))
                return $this->resultForApi(400, [], "非法操作");

            if (OaWechat::destroy($id)) return $this->resultForApi(200, $id);
            else
                return $this->resultForApi(400, [], "操作失败");
        } else {
            return $this->resultForApi(400, [], "信息不存在");
        }

    }
}