<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 17:33
 */

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatGraphic;

/**
 * 添加图文
 * Class StoreNews
 * @package App\Endpoints\News
 */
class StoreNews extends BaseEndpoint
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeNews() {
        $this->validate($this->request,$this->rules());
        $fans = new WechatGraphic();
        $fans = $this->setAttribute($fans);
        $fans->save();
        if ($fans)
            return $this->resultForApi(200, $fans);
        else
            return $this->resultForApi(400, [], "操作失败");
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