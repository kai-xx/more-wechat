<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:04
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\MessageOptions;
use App\Models\WechatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 添加消息
 * Class StoreMessage
 * @package App\Http\Endpoints\Message
 */
class StoreMessage extends BaseEndpoint
{


    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeMessage()
    {
        $this->validate($this->request,$this->rules());
//        return response($this->request,200);
        try {
            $message = DB::transaction(function () {
                $message = new WechatMessage();
                $message = $this->setAttribute($message);
                $message->setAttribute(WechatMessage::DB_FILED_MANAGER_ID, Auth::user()->getKey());
                $message->setAttribute(WechatMessage::DB_FILED_STATE, WechatMessage::STATE_OPEN);
                $message->save();

                $options = $this->request->input('messageArray');
                $optionsModel = new MessageOptions();
                foreach ($options as $value){
                    $optionsModel->{MessageOptions::DB_FILED_RESOURCE_ID} = $value['id'];
                    $optionsModel->{MessageOptions::DB_FILED_MESSAGE_ID} = $message->getKey();
                    $optionsModel->{MessageOptions::DB_FILED_MANAGER_ID} = Auth::user()->getKey();
                    $optionsModel->{MessageOptions::DB_FILED_TYPE} = $this->request->input('messageType');
                    $optionsModel->save();
                }
                return $message;
            }, 2);
            return $this->resultForApi(200, $message);
        } catch (\Exception $e) {
            app('log')->error("操作失败,错误原因" . $e->getMessage());
            return $this->resultForApi(400, [], "操作失败" . $e->getMessage());

        }
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

