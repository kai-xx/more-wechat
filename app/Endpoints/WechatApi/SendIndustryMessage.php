<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/5
 * Time: 下午1:21
 */

namespace App\Endpoints\WechatApi;


use App\Models\Industry;
use App\Models\IndustryMessage;
use App\Models\IndustryMessageFansTagOption;
use App\Models\IndustryMessageSendLog;
use App\Models\OaWechat;
use App\Models\SendMessageLog;
use App\Models\WechatFans;
use App\Models\WechatFansTagOption;
use App\Models\WechatMessageFansTagOption;

class SendIndustryMessage extends BaseApi
{
    private $success = 0;
    private $failure = 0;
    private $total = 0;
    public function sendMessage()
    {
        $industryId = $this->request->input("industry_id");

        $industry = Industry::find($industryId);
        if ($industry instanceof Industry) {
            if (!$this->verifyOperationRightsByOaWechatId($industry->{Industry::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');
            $industryMessage = IndustryMessage::where(IndustryMessage::DB_FILED_INDUSTRY_ID, $industry->getKey())->first();
            if (!($industryMessage instanceof IndustryMessage)) return  $this->resultForApi(400, '请编辑模版消息内容');
            $wechat = OaWechat::find($industry->{Industry::DB_FILED_OA_WECHAT_ID});
            $token = $this->getToken($wechat->{OaWechat::DB_FILED_APP_ID}, $wechat->{OaWechat::DB_FILED_APP_SECRET});
            $this->getSendFans($industryMessage)
                ->each(function ($item) use ($industryMessage, $token, $industry) {
                    $message = $this->getTemplateMessage($industryMessage, $item);

                    $result = $this->sendTemplateMessage($token,
                        $item->{WechatFans::DB_FILED_OPEN_ID},
                        $industry->{Industry::DB_FILED_TEMPLATE_ID},
                        $industryMessage->{IndustryMessage::DB_FILED_APPLET_URI},
                        $industryMessage->{IndustryMessage::DB_FILED_APPLET_APP_ID},
                        $industryMessage->{IndustryMessage::DB_FILED_APPLET_PATH},
                        $message
                        );
                    if (isset($result['errcode']) && $result['errcode'] == 0){
                        $this->writeLog($item, $industryMessage, SendMessageLog::STATUS_SUCCESS);
                        $this->success ++;
                    }else{
                        $this->writeLog($item, $industryMessage, SendMessageLog::STATUS_FALSE, $result['errmsg']);
                        $this->failure ++;
                    }
                });


            return $this->resultForApi(200, [
                'success' => $this->success,
                'failure' => $this->failure
            ],'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }

    private function getSendFans(IndustryMessage $industryMessage) {
        $fans =  WechatFans::where(IndustryMessageFansTagOption::DB_FILED_INDUSTRY_MESSAGE_ID, $industryMessage->getKey())
            ->leftJoin(
                WechatFansTagOption::TABLE_NAME,
                WechatFansTagOption::DB_FILED_FANS_ID, "=",
                WechatFans::TABLE_NAME . "." . WechatFans::DB_FILED_ID
            )
            ->leftJoin(
                IndustryMessageFansTagOption::TABLE_NAME,
                IndustryMessageFansTagOption::TABLE_NAME. "." .IndustryMessageFansTagOption::DB_FILED_TAG_ID, "=",
                WechatFansTagOption::TABLE_NAME . "." . WechatFansTagOption::DB_FILED_TAG_ID
            )
            ->select(WechatFans::TABLE_NAME . ".*")
            ->groupBy(WechatFans::DB_FILED_ID)
            ->get();
        return $fans;
    }
    private function getTemplateMessage(IndustryMessage $industryMessage, $fans){
        $result = [];
        $content = json_decode($industryMessage->{IndustryMessage::DB_FILED_CONTENT}, true);
        foreach ($content as $key=>$value) {
            if ($key == "first") {
                $value = str_replace("--昵称--",$fans->{WechatFans::DB_FILED_NIKE},$value);
                $result[$key] = $value;
            }
            if ($key == "keywords") {
                foreach ($value as $k=>$item) {
                    $item = str_replace("--昵称--",$fans->{WechatFans::DB_FILED_NIKE},$item);
                    $result['keyword'. ($k+1)] = $item;
                }
            }
            if ($key == "remark") {
                $value = str_replace("--昵称--",$fans->{WechatFans::DB_FILED_NIKE},$value);
                $result[$key] = $value;
            }
        }
        return $result;
    }

    private function writeLog(WechatFans $fans, IndustryMessage $industryMessage, $status, $reason=''){
        $log = new IndustryMessageSendLog();
        $log->{IndustryMessageSendLog::DB_FILED_FANS_ID} = $fans->getKey();
        $log->{IndustryMessageSendLog::DB_FILED_INDUSTRY_MESSAGE_ID} = $industryMessage->getKey();
        $log->{IndustryMessageSendLog::DB_FILED_STATUS} = $status;
        $log->{IndustryMessageSendLog::DB_FILED_REASON} = empty($reason) ? '' : $reason;
        $log->save();
        return $log;
    }
}
