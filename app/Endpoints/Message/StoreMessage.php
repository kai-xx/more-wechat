<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:04
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatMessage;
use Illuminate\Support\Facades\Auth;

/**
 * 添加消息
 * Class StoreMessage
 * @package App\Http\Endpoints\Message
 */
class StoreMessage extends BaseEndpoint
{


    /**
     * @return WechatMessage|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeMessage()
    {
        $this->validate($this->request,$this->rules());
        return response(200,200);
        $message = new WechatMessage();
        $message = $this->setAttribute($message);
        $message->setAttribute(WechatMessage::DB_FILED_MANAGER_ID, Auth::user()->getKey());
        $message->setAttribute(WechatMessage::DB_FILED_STATE, WechatMessage::STATE_OPEN);
        $message->save();

        if ($message)
            return $this->resultForApi(200, $message);
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

