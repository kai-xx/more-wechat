<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/5
 * Time: 下午1:21
 */

namespace App\Endpoints\WechatApi;


use App\Models\MessageOptions;
use App\Models\OaWechat;
use App\Models\WechatFans;
use App\Models\WechatGraphic;
use App\Models\WechatMessage;

class SendMessage extends BaseApi
{
    private $success = 0;
    private $failure = 0;
    private $total = 0;
    public function sendMessage()
    {
        $messageId = $this->request->input("message_id");

        $message = WechatMessage::find($messageId);
        if ($message instanceof WechatMessage) {
            if (!$this->verifyOperationRightsByOaWechatId($message->{WechatMessage::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');
            $wechat = OaWechat::find($message->{WechatMessage::DB_FILED_OA_WECHAT_ID});
            $token = $this->getToken($wechat->{OaWechat::DB_FILED_APP_ID}, $wechat->{OaWechat::DB_FILED_APP_SECRET});
            switch ($message->{WechatMessage::DB_FILED_MESSAGE_TYPE}){
                case 3:
                    $news = $this->getNews($message);
                    $this->getSendFans($message->{WechatMessage::DB_FILED_OA_WECHAT_ID})
                        ->each(function ($item) use ($news, $token) {
                            $result = $this->sendMessageByNews($token, $item->{WechatFans::DB_FILED_OPEN_ID}, $news);
                            if (isset($result['errcode']) && $result['errcode'] == 0){
                                $this->success ++;
                            }else{
                                $this->failure ++;
                            }
                        });
                    break;
            }

            return $this->resultForApi(200, [
                'success' => $this->success,
                'failure' => $this->failure
            ],'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }

    private function getSendFans($wechatId) {
        return WechatFans::where(WechatFans::DB_FILED_OA_WECHAT_ID, $wechatId)
            ->get();
    }

    private function getNews($message){
        $option = MessageOptions::where(MessageOptions::DB_FILED_MESSAGE_ID , $message->getKey())
            ->leftJoin(
                WechatGraphic::TABLE_NAME,
                MessageOptions::DB_FILED_RESOURCE_ID, "=",
                WechatGraphic::TABLE_NAME . "." . WechatGraphic::DB_FILED_ID
            )
            ->select(WechatGraphic::TABLE_NAME . ".*")
            ->orderBy(MessageOptions::DB_FILED_ID, "ASC")
            ->get();
        $news = [];
        $option->each(function ($item) use (&$news) {
            $data = [
                "title" => $item->{WechatGraphic::DB_FILED_TITLE},
                "description" => $item->{WechatGraphic::DB_FILED_DETAIL},
                "url" => $item->{WechatGraphic::DB_FILED_URL},
                "picurl" => $item->{WechatGraphic::DB_FILED_PATH}
            ];
            $news[] = $data;
        });
        return $news;
    }
}