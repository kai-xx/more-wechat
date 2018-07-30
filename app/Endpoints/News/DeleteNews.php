<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:41
 */

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatGraphic;

/**
 * 删除图文
 * Class DeleteNews
 * @package App\Endpoints\News
 */
class DeleteNews extends BaseEndpoint
{
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(int $id){
        $news = (new WechatGraphic())->find($id);
        if ($news instanceof WechatGraphic) {
            if (!$this->verifyOperationRightsByOaWechatId($news->{WechatGraphic::DB_FILED_MANAGER_ID}))
                return $this->resultForApi(400, [], "非法操作");

            if (WechatGraphic::destroy($id)) return $this->resultForApi(200, $id);
            else
                return $this->resultForApi(400, [], "操作失败");
        } else {
            return $this->resultForApi(400, [], "信息不存在");
        }

    }
}