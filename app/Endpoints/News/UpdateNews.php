<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:39
 */

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatGraphic;

/**
 * 编辑图文
 * Class UpdateNews
 * @package App\Endpoints\Wechat
 */
class UpdateNews extends BaseEndpoint
{
    /**
     * @return WechatGraphic WechatGraphic
     */
    public function news() {
        return new WechatGraphic();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateNews(int $id)
    {
        $this->validate($this->request,$this->rules());

        $fans = $this->news()->find($id);
        if ($fans instanceof WechatGraphic) {

            if (!$this->verifyOperationRightsByOaWechatId($fans->{WechatGraphic::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');

            $fans = $this->setAttribute($fans);
            if ($fans->save())
                return $fans;
            else
                return  $this->resultForApi(400, '更改失败');
        } else {
            return  $this->resultForApi(400, '信息不存在');
        }
    }

    /**
     * 验证规则
     * @return array
     */
    private function rules() {

        return [

        ];
    }
}