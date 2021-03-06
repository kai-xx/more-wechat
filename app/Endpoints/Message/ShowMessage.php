<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 18:11
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\MessageOptions;
use App\Models\WechatGraphic;
use App\Models\WechatMessage;
use App\Models\WechatMessageFansTagOption;
use Illuminate\Support\Collection;

class ShowMessage extends BaseEndpoint
{
    /**
     * @return WechatMessage WechatMessage
     */
    public function wechat() {
        return new WechatMessage();
    }
    public function showMessage(int $id)
    {
        $message = $this->wechat()->find($id);
        if ($message instanceof WechatMessage) {
            if (!$this->verifyOperationRightsByOaWechatId($message->{WechatMessage::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');
            switch ($message->{WechatMessage::DB_FILED_MESSAGE_TYPE}){
                case 1:
                case 2:
                case 3:
                case 4:
                    $option = MessageOptions::where(MessageOptions::DB_FILED_MESSAGE_ID , $message->getKey())
                        ->leftJoin(
                            WechatGraphic::TABLE_NAME,
                            MessageOptions::DB_FILED_RESOURCE_ID, "=",
                            WechatGraphic::TABLE_NAME . "." . WechatGraphic::DB_FILED_ID
                        )
                        ->select(WechatGraphic::TABLE_NAME . ".*")
                        ->orderBy(MessageOptions::DB_FILED_ID, "ASC")
                        ->get();
                    break;
                default:
                    $option = new Collection();
                    break;
            }
            $tagInfo = WechatMessageFansTagOption::where(WechatMessageFansTagOption::DB_FILED_MESSAGE_ID, $message->getKey())
                ->get();
            $tags = $tagInfo->pluck(WechatMessageFansTagOption::DB_FILED_TAG_ID);
            $message->setAttribute('messageArray', $option);
            $message->setAttribute('tags', $tags);

            return $this->resultForApi(200, $message,'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }
}