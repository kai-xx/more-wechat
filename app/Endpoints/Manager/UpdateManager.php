<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:39
 */

namespace App\Endpoints\Manager;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;

class UpdateManager extends BaseEndpoint
{
    public function updateManager(int $id)
    {
        $this->validate($this->request,$this->rules());
        $manager = new Manager();
        $manager = $this->setAttribute($manager->find($id));
        if ($manager->save())
            return $manager;
        else
            return null;
    }

    private function rules() {

        return [
            Manager::DB_FILED_NAME => '',
            Manager::DB_FILED_LOGIN_NAME => 'alpha_num|between:6,16|unique:' . Manager::TABLE_NAME,
            Manager::DB_FILED_TYPE => '',
            Manager::DB_FILED_STATE => '',
            Manager::DB_FILED_OA_WECHAT_ID => '',
            Manager::DB_FILED_PARENT_ID => '',
            Manager::DB_FILED_PHONE => '',
            Manager::DB_FILED_EMAIL => 'email',
            Manager::DB_FILED_QQ => 'numeric',
            Manager::DB_FILED_WECHAT_NUMBER => 'alpha_num'
        ];
    }
}