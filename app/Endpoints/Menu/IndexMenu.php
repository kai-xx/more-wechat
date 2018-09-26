<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/9/26
 * Time: 16:35
 */

namespace App\Endpoints\Menu;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatMenu;

/**
 * 查询菜单信息
 * Class IndexMenu
 * @package App\Endpoints\Menu
 */
class IndexMenu extends BaseEndpoint
{
    const ARGUMENT_SHOW_DELETE = "showDelete";
    /**
     * @return mixed
     */
    public function index()
    {
        $filters = [];
        $wechatId = $this->request->input(WechatMenu::DB_FILED_OA_WECHAT_ID);
        $wechatIds = $this->request->input('wechatIds');
        if (empty($wechatIds) && !in_array($wechatId, $wechatIds)) {
            return $this->resultForApi(200, [], 0);
        }
        if ($wechatId) $filters[] = [WechatMenu::DB_FILED_OA_WECHAT_ID, "=", $wechatId];

        $menu = WechatMenu::where($filters)
        ->whereIn(WechatMenu::DB_FILED_OA_WECHAT_ID, $wechatIds)
        ->get();

        if ($menu == false)
            return $this->resultForApi(400, $menu, "查询失败");
        else
            return $this->resultForApi(200, $menu);
    }
}