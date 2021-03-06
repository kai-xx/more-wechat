<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 18:11
 */

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatGraphic;

class ShowNews extends BaseEndpoint
{
    /**
     * @return WechatGraphic WechatGraphic
     */
    public function news() {
        return new WechatGraphic();
    }
    public function showNews(int $id)
    {
        $news = $this->news()->find($id);
        if ($news instanceof WechatGraphic) {
            if (!$this->verifyOperationRightsByOaWechatId($news->{WechatGraphic::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');
            return $this->resultForApi(200, $news,'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }
}