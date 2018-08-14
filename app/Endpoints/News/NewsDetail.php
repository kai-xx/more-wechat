<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/8/14
 * Time: 16:12
 */

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\OaWechat;
use App\Models\WechatGraphic;

class NewsDetail extends BaseEndpoint
{
    /**
     * @return WechatGraphic WechatGraphic
     */
    public function news() {
        return new WechatGraphic();
    }
    public function newsDetail($id)
    {
        $news = $this->news()->find($id);
        if ($news instanceof WechatGraphic) {
            $wechat = OaWechat::find($news->{WechatGraphic::DB_FILED_OA_WECHAT_ID});
            $news->wechat_name = $wechat->{OaWechat::DB_FILED_NAME};
            $news->qrcode_path = $wechat->{OaWechat::DB_FILED_IMAGE};
            return $this->resultForApi(200, $news,'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }
}