<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/8/9
 * Time: 14:14
 */

namespace App\Endpoints\WechatApi;


use App\Models\Industry;
use App\Models\OaWechat;

class UpdateIndustry extends BaseApi
{
    private $add = 0;
    private $edit = 0;
    private $success = 0;
    private $overlook = 0;
    private $failure = 0;
    private $total = 0;
    public function updateIndustry()
    {
        $wechatId = $this->request->input('oa_wechat_id');
        $force = $this->request->input("force");
        if (empty($wechatId)) return $this->resultForApi(400,[],'请选择公众号');
        $wechat = OaWechat::find($wechatId);
        if (!($wechat instanceof OaWechat)) $this->resultForApi(400,[],'公众号不存在');
        if (!$this->verifyOperationRightsByOaWechatId($wechatId)) $this->resultForApi(400,[],'非法操作');
        $token = $this->getToken($wechat->{OaWechat::DB_FILED_APP_ID}, $wechat->{OaWechat::DB_FILED_APP_SECRET});
        if (is_object($token)) return $token;

        $industry = $this->getTemplateList($token);
        if (isset($industry['errcode']) || !isset($industry['template_list'])) {
            app('log')->error("微信接口返回异常:" . $industry['errmsg']);
            return $this->resultForApi(400,[],'微信接口返回异常');
        } else {
            foreach ($industry['template_list'] as $value) {
                if (empty($value)) continue;
                $industryModel = Industry::where([
                    Industry::DB_FILED_OA_WECHAT_ID => $wechatId,
                    Industry::DB_FILED_TEMPLATE_ID => $value['template_id']
                ])->first();

                if ($industryModel instanceof Industry) {
                    if (!$force) {
                        $this->overlook ++;
                        continue;
                    }
                } else {
                    $industryModel = new Industry();
                }

                $industryModel->{Industry::DB_FILED_OA_WECHAT_ID} = $wechatId;
                $industryModel->{Industry::DB_FILED_TEMPLATE_ID} = $value['template_id'];
                $industryModel->{Industry::DB_FILED_TITLE} = $value['title'];
                $industryModel->{Industry::DB_FILED_PRIMARY_INDUSTRY} = $value['primary_industry'];
                $industryModel->{Industry::DB_FILED_DEPUTY_INDUSTRY} = $value['deputy_industry'];
                $industryModel->{Industry::DB_FILED_CONTENT} = $value['content'];
                $industryModel->{Industry::DB_FILED_EXAMPLE} = $value['example'];
                if ($industryModel->save()) {
                    $this->success ++;
                    if ($force) {
                        $this->edit ++;
                    } else {
                        $this->add ++;
                    }
                }else {
                    $this->failure ++;
                }
            }
        }
        return $this->resultForApi(200, [
            "add" => $this->add,
            "edit" => $this->edit,
            "overlook" => $this->overlook,
            "success" => $this->success,
            "failure" => $this->failure
        ],'');
    }



}