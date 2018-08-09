<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/8/9
 * Time: 14:14
 */

namespace App\Endpoints\WechatApi;


use App\Models\OaWechat;
use App\Models\WechatFansTag;

class UpdateTags extends BaseApi
{
    private $add = 0;
    private $edit = 0;
    private $success = 0;
    private $overlook = 0;
    private $failure = 0;
    private $total = 0;
    public function updateTags()
    {
        $wechatId = $this->request->input('oa_wechat_id');
        $force = $this->request->input("force");
        if (empty($id)) return $this->resultForApi(400,[],'请选择公众号');
        $wechat = OaWechat::find($wechatId);
        if (!($wechat instanceof OaWechat)) $this->resultForApi(400,[],'公众号不存在');
        if (!$this->verifyOperationRightsByOaWechatId($wechatId)) $this->resultForApi(400,[],'非法操作');
        $token = $this->getToken($wechat->{OaWechat::DB_FILED_APP_ID}, $wechat->{OaWechat::DB_FILED_APP_SECRET});
        if (is_object($token)) return $token;

        $tags = $this->getFansTags($token);

        if (isset($tags['errcode']) || !isset($tags['tags'])) {
            app('log')->error("微信接口返回异常:" . $tags['errmsg']);
            return $this->resultForApi(400,[],'微信接口返回异常');
        } else {
            foreach ($tags['tags'] as $value) {
                $tagModel = WechatFansTag::where([
                    WechatFansTag::DB_FILED_OA_WECHAT_ID => $wechatId,
                    WechatFansTag::DB_FILED_TAG_ID => $value['id']
                ])->first();

                if (!$force) {
                    if ($tagModel instanceof WechatFansTag) {
                        $this->overlook ++;
                        continue;
                    }
                    $tagModel = new WechatFansTag();
                }
                $tagModel->{WechatFansTag::DB_FILED_OA_WECHAT_ID} = $wechatId;
                $tagModel->{WechatFansTag::DB_FILED_TAG_ID} = $value['id'];
                $tagModel->{WechatFansTag::DB_FILED_TAG_NAME} = $value['name'];
                $tagModel->{WechatFansTag::DB_FILED_COUNT} = $value['count'];
                if ($tagModel->save()) {
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