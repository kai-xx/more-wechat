<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:04
 */

namespace App\Http\Endpoints\Fans;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatFans;

/**
 * 添加公众号粉丝
 * Class StoreFans
 * @package App\Http\Endpoints\Fans
 */
class StoreFans extends BaseEndpoint
{


    /**
     * @return WechatFans|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeFans()
    {
        $this->validate($this->request,$this->rules());
        $fans = new WechatFans();
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

