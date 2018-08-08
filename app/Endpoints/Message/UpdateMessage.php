<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:39
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\MessageOptions;
use App\Models\WechatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            if (!$this->verifyOperationRightsByOaWechatId($message->{WechatMessage::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, [],'非法操作');

            try {
                $result = DB::transaction(function () use ($message){
                    $message = $this->setAttribute($message);
                    $message->save();
                    MessageOptions::where(MessageOptions::DB_FILED_MESSAGE_ID, $message->getKey())
                    ->delete();
                    $options = $this->request->input('messageArray');
                    foreach ($options as $value){
                        $optionsModel = new MessageOptions();
                        $optionsModel->{MessageOptions::DB_FILED_RESOURCE_ID} = $value['id'];
                        $optionsModel->{MessageOptions::DB_FILED_MESSAGE_ID} = $message->getKey();
                        $optionsModel->{MessageOptions::DB_FILED_MANAGER_ID} = Auth::user()->getKey();
                        $optionsModel->save();
                    }
                    return $message;
                });
                return  $this->resultForApi(200, $result,'');
            } catch (\Exception $e) {
                app('log')->error("更改失败" . $e->getMessage());
                return  $this->resultForApi(400, [],'更改失败');
            }
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