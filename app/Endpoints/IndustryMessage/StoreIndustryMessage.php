<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/26
 * Time: 下午12:01
 */

namespace App\Endpoints\IndustryMessage;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Industry;
use App\Models\IndustryMessage;
use App\Models\IndustryMessageFansTagOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreIndustryMessage extends BaseEndpoint
{
    public function addIndustryMessage($industryId)
    {
        $this->validate($this->request,$this->rules());
        try {
            $message = DB::transaction(function () use ($industryId) {
                $industry = Industry::find($industryId);

                if (!($industry instanceof Industry)) return  $this->resultForApi(400, '非法操作');

                $industryMessage = IndustryMessage::where([
                    IndustryMessage::DB_FILED_INDUSTRY_ID => $industryId
                ])->first();

                if (!($industryMessage instanceof IndustryMessage)) {
                    $industryMessage = new IndustryMessage();
                }

                $industryMessage = $this->setAttribute($industryMessage);
                if (!$this->verifyOperationRightsByOaWechatId($industry->{Industry::DB_FILED_OA_WECHAT_ID}))
                    return  $this->resultForApi(400, '非法操作');
                $first = $this->request->input('first');
                $keywords = $this->request->input('keywords');
                $send_remark = $this->request->input('send_remark');
                $content = [
                    'first' => $first,
                    'keywords' => $keywords,
                    'remark' => $send_remark
                ];
                $industryMessage->setAttribute(IndustryMessage::DB_FILED_INDUSTRY_ID, $industryId);
                $industryMessage->setAttribute(IndustryMessage::DB_FILED_CONTENT, json_encode($content, JSON_UNESCAPED_UNICODE));
                $industryMessage->setAttribute(IndustryMessage::DB_FILED_STATE, IndustryMessage::STATE_OPEN);
                $industryMessage->setAttribute(IndustryMessage::DB_FILED_MANAGER_ID, Auth::user()->getKey());

                $industryMessage->save();


                $tags = $this->request->input('tags');
                foreach ($tags as $tag){
                    $tagOption = new IndustryMessageFansTagOption();
                    $tagOption->{IndustryMessageFansTagOption::DB_FILED_INDUSTRY_MESSAGE_ID} = $industryMessage->getKey();
                    $tagOption->{IndustryMessageFansTagOption::DB_FILED_TAG_ID} = $tag;
                    $tagOption->save();
                }
                return [];
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