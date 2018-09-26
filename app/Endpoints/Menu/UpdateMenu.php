<?php

namespace App\Endpoints\News;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\WechatMenu;

class UpdateMenu extends BaseEndpoint
{
    public function menu() {
        return new WechatMenu();
    }

    public function updateMenu(int $id)
    {
        $this->validate($this->request,$this->rules());

        $menu = $this->menu()->find($id);
        if ($menu instanceof WechatMenu) {

            if (!$this->verifyOperationRightsByOaWechatId($menu->{WechatMenu::DB_FILED_OA_WECHAT_ID}))
                return  $this->resultForApi(400, '非法操作');

            $menu = $this->setAttribute($menu);
            if ($menu->save())
                return $menu;
            else
                return  $this->resultForApi(400, '更改失败');
        } else {
            return  $this->resultForApi(400, '信息不存在');
        }
    }

    /**
     * 验证规则
     * @return array
     */
    private function rules() {

        return [

        ];
    }
}