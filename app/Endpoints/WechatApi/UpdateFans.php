<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/4
 * Time: 下午8:46
 */

namespace App\Endpoints\WechatApi;

use App\Models\OaWechat;
use App\Models\WechatFans;
use App\Models\WechatFansTagOption;
use Illuminate\Support\Collection;

class UpdateFans extends BaseApi
{
    private $add = 0;
    private $edit = 0;
    private $success = 0;
    private $overlook = 0;
    private $failure = 0;
    private $total = 0;
    public function updateFans()
    {
        $id = $this->request->input("oa_wechat_id");
        $force = $this->request->input("force");
        if (empty($id)) return $this->resultForApi(400,[],'请选择公众号');
        $wechat = OaWechat::find($id);
        if (!($wechat instanceof OaWechat)) $this->resultForApi(400,[],'公众号不存在');
        if (!$this->verifyOperationRightsByOaWechatId($id)) $this->resultForApi(400,[],'非法操作');
        $token = $this->getToken($wechat->{OaWechat::DB_FILED_APP_ID}, $wechat->{OaWechat::DB_FILED_APP_SECRET});
        if (is_object($token)) return $token;
        $cycle = true;
        $nextId = "";
        while ($cycle) {
            $fans = $this->getFans($token, $nextId);
            if ($this->total == 0) $this->total = $fans['total'];
            if ($fans['total'] > 10000 && $fans['count'] == 10000){
                $cycle = true;
                $nextId = $fans['next_openid'];
            }else
                $cycle = false;
            $collection = new Collection($fans['data']['openid']);
            $collection->chunk(1)->each(function($openIds) use ($token, $id, $force) {
                $filter = [];
                foreach ($openIds as $openId) {
                    $filter[] = [
                        "openid" => $openId,
                        "lang" => "zh_CN"
                    ];
                }
                if (empty($filter)) return;
                $userInfo = $this->batchGetUserInfo($token, $filter);
                foreach ($userInfo['user_info_list'] as $user){
                    if (empty($user)) continue;

                    $fansModel = WechatFans::where([
                        WechatFans::DB_FILED_OA_WECHAT_ID => $id,
                        WechatFans::DB_FILED_OPEN_ID => $openId
                    ])->first();

                    if ($fansModel instanceof WechatFans) {
                        if (!$force) {
                            $this->overlook ++;
                            continue;
                        }
                    }else{
                        $fansModel = new WechatFans();

                    }

                    $fansModel->{WechatFans::DB_FILED_SUBSCRIBE} = $user['subscribe'];
                    $fansModel->{WechatFans::DB_FILED_OPEN_ID} = $user['openid'];
                    $fansModel->{WechatFans::DB_FILED_OA_WECHAT_ID} = $id;
                    if ($user['subscribe'] == 1) {
                        $fansModel->{WechatFans::DB_FILED_NIKE} = $user['nickname'];
                        $fansModel->{WechatFans::DB_FILED_SEX} = $user['sex'];
                        $fansModel->{WechatFans::DB_FILED_CITY} = $user['city'];
                        $fansModel->{WechatFans::DB_FILED_PROVINCE} = $user['province'];
                        $fansModel->{WechatFans::DB_FILED_COUNTRY} = $user['country'];
                        $fansModel->{WechatFans::DB_FILED_HEAD_IMG} = $user['headimgurl'];
                        $fansModel->{WechatFans::DB_FILED_SUBSCRIBE_TIME} = date("Y-m-d H:i:s", $user['subscribe_time']);
                        $fansModel->{WechatFans::DB_FILED_REMARK} = $user['remark'];
                        $fansModel->{WechatFans::DB_FILED_GROUPID} = $user['groupid'];
                        $fansModel->{WechatFans::DB_FILED_SUBSCRIBE_SCENE} = $user['subscribe_scene'];
                        $fansModel->{WechatFans::DB_FILED_TAG_IDS} = implode(',', $user['tagid_list']);
                    }
                    if ($fansModel->save()) {
                        $this->success ++;
                        if ($force) {
                            $this->edit ++;
                        } else {
                            $this->add ++;
                        }
                    }else {
                        $this->failure ++;
                    }
                    WechatFansTagOption::where(WechatFansTagOption::DB_FILED_FANS_ID, $fansModel->getKey())
                        ->forceDelete();
                    foreach ($user['tagid_list'] as $tag) {
                        $tagOption = new WechatFansTagOption();
                        $tagOption->{WechatFansTagOption::DB_FILED_FANS_ID} = $fansModel->getKey();
                        $tagOption->{WechatFansTagOption::DB_FILED_TAG_ID} = $tag;
                        $tagOption->save();
                    }
                }
            });
        }
        return $this->resultForApi(200, [
            "add" => $this->add,
            "edit" => $this->edit,
            "overlook" => $this->overlook,
            "success" => $this->success,
            "failure" => $this->failure,
            "total" => $this->total
        ],'');
    }
}