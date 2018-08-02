<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:39
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;
use App\Models\WechatMessage;

/**
 * 编辑消息
 * Class UpdateMessage
 * @package App\Endpoints\Message
 */
class UpdateMessage extends BaseEndpoint
{
    /**
     * @return WechatMessage WechatMessage
     */
    public function oaMessage() {
        return new WechatMessage();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateMessage(int $id)
    {
        $this->validate($this->request,$this->rules());

        $message = $this->oaMessage()->find($id);
        if ($message instanceof WechatMessage) {
            $manager = Manager::find($message->{WechatMessage::DB_FILED_MANAGER_ID});
            if (!$this->verifyOperationPermissions($manager))
                return  $this->resultForApi(400, [],'非法操作');

            $message = $this->setAttribute($message);
            if ($message->save())
                return  $this->resultForApi(200, $message,'');
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