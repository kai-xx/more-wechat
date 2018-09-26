<?php

namespace App\Endpoints\Menu;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatGraphic;
use App\Models\WechatMenu;
use Illuminate\Support\Facades\Auth;


class StoreMenu extends BaseEndpoint
{

    public function storeMenu() {
        $this->validate($this->request,$this->rules());
        $menu = new WechatMenu();
        $menu = $this->setAttribute($menu);

        if (!$this->verifyOperationRightsByOaWechatId($menu->{WechatMenu::DB_FILED_OA_WECHAT_ID}))
            return  $this->resultForApi(400, '非法操作');
        $menu->setAttribute(WechatMenu::DB_FILED_MANAGER_ID, Auth::user()->getKey());
        $menu->save();
        if ($menu)
            return $this->resultForApi(200, $menu);
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