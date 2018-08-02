<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 18:11
 */

namespace App\Endpoints\Message;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatMessage;

class ShowMessage extends BaseEndpoint
{
    /**
     * @return WechatMessage WechatMessage
     */
    public function wechat() {
        return new WechatMessage();
    }
    public function showMessage(int $id)
    {
        $message = $this->wechat()->find($id);
        if ($message instanceof WechatMessage) {
                return $this->resultForApi(200, $message,'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }
}