<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:41
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatMessage;

/**
 * 删除消息
 * Class DeleteMessage
 * @package App\Endpoints\Message
 */
class DeleteMessage extends BaseEndpoint
{
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(int $id){
        $message = (new WechatMessage())->find($id);
        if ($message instanceof WechatMessage) {
            if (!$this->verifyOperationPermissions($message))
                return $this->resultForApi(400, [], "非法操作");

            if (WechatMessage::destroy($id)) return $this->resultForApi(200, $id);
            else
                return $this->resultForApi(400, [], "操作失败");
        } else {
            return $this->resultForApi(400, [], "信息不存在");
        }

    }
}