<?php


namespace App\Endpoints\Menu;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatGraphic;
use App\Models\WechatMenu;

/**
 * 查询菜单详情
 * Class ShowMenu
 * @package App\Endpoints\Menu
 */
class ShowMenu extends BaseEndpoint
{

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showMenu(int $id)
    {
        $menu = WechatMenu::find($id);
        if ($menu instanceof WechatMenu) {
            if (!$this->verifyOperationRightsByOaWechatId($menu->{WechatMenu::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');
            return $this->resultForApi(200, $menu,'');
        } else {
            return  $this->resultForApi(400, [],'信息不存在');
        }
    }
}