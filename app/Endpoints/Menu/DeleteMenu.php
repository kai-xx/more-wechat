<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:41
 */

namespace App\Endpoints\Menu;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatMenu;

/**
 * 删除菜单
 * Class DeleteMenu
 * @package App\Endpoints\Menu
 */
class DeleteMenu extends BaseEndpoint
{
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(int $id){
        $news = (new WechatMenu())->find($id);
        if ($news instanceof WechatMenu) {
            if (!$this->verifyOperationRightsByOaWechatId($news->{WechatMenu::DB_FILED_MANAGER_ID}))
                return $this->resultForApi(400, [], "非法操作");

            if (WechatMenu::destroy($id)) return $this->resultForApi(200, $id);
            else
                return $this->resultForApi(400, [], "操作失败");
        } else {
            return $this->resultForApi(400, [], "信息不存在");
        }

    }
}