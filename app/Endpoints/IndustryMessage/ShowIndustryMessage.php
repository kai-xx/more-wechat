<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 18:11
 */

namespace App\Endpoints\IndustryMessage;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Industry;
use App\Models\IndustryMessage;
use App\Models\IndustryMessageFansTagOption;

class ShowIndustryMessage extends BaseEndpoint
{

    public function showMessage(int $id)
    {
        $industry = Industry::find($id);
        if ($industry instanceof Industry) {
            if (!$this->verifyOperationRightsByOaWechatId($industry->{Industry::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');
            $industry->setAttribute(Industry::DB_FILED_CONTENT, str_replace([
                "\r\n","\r","\n"
            ], '<br/>', $industry->{Industry::DB_FILED_CONTENT}));
            $message = IndustryMessage::where(IndustryMessage::DB_FILED_INDUSTRY_ID , $industry->getKey())
                ->first();
            if ($message instanceof IndustryMessage) {
                $tagInfo = IndustryMessageFansTagOption::where(IndustryMessageFansTagOption::DB_FILED_INDUSTRY_MESSAGE_ID, $industry->getKey())
                    ->get();
                $tags = $tagInfo->pluck(IndustryMessageFansTagOption::DB_FILED_TAG_ID);
                $industry->setAttribute('tags', empty($tags) ? [] : $tags);
                $content = json_decode($message->{IndustryMessage::DB_FILED_CONTENT}, true);
                foreach ($content as $key=>$value) {
                    if ($key == "first") {
                        $industry->setAttribute($key, $value);
                    }
                    if ($key == "keywords") {
                        $industry->setAttribute($key, $value);
                    }
                    if ($key == "remark") {
                        $industry->setAttribute('send_remark', $value);
                    }
                }
                $industry->setAttribute('type', $message->{IndustryMessage::DB_FILED_TYPE});
                $industry->setAttribute('send_at', $message->{IndustryMessage::DB_FILED_SEND_AT});
                $industry->setAttribute(IndustryMessage::DB_FILED_APPLET_APP_ID,$message->{IndustryMessage::DB_FILED_APPLET_APP_ID});
                $industry->setAttribute(IndustryMessage::DB_FILED_APPLET_URI,$message->{IndustryMessage::DB_FILED_APPLET_URI});
                $industry->setAttribute(IndustryMessage::DB_FILED_APPLET_PATH,$message->{IndustryMessage::DB_FILED_APPLET_PATH});
            } else {
                $industry->setAttribute('keywords', [[]]);
                $industry->setAttribute('first', []);
                $industry->setAttribute('send_remark', []);
                $industry->setAttribute(IndustryMessage::DB_FILED_APPLET_APP_ID,'');
                $industry->setAttribute(IndustryMessage::DB_FILED_APPLET_URI,'');
                $industry->setAttribute(IndustryMessage::DB_FILED_APPLET_PATH,'');
                $industry->setAttribute('tags', []);

            }
            return $this->resultForApi(200, $industry,'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }
}