<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 18:11
 */

namespace App\Endpoints\Wechat;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\OaWechat;

class ShowWechat extends BaseEndpoint
{
    /**
     * @return OaWechat OaWechat
     */
    public function wechat() {
        return new OaWechat();
    }
    public function showWechat(int $id)
    {
        $news = $this->wechat()->find($id);
        if ($news instanceof OaWechat) {
                return $this->resultForApi(200, $news,'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }
}