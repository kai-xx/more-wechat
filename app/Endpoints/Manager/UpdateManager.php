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


/**
 * 编辑用户
 * Class UpdateManager
 * @package App\Endpoints\Manager
 */
class UpdateManager extends BaseEndpoint
{
    /**
     * @return Manager Manager
     */
    public function manager() {
        return new Manager();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateManager(int $id)
    {
        $this->validate($this->request,$this->rules());

        $manager = $this->manager()->find($id);
        if ($manager instanceof Manager) {

            if (!$this->verifyOperationPermissions($manager))
                return  $this->resultForApi(400, '非法操作');

            $manager = $this->setAttribute($manager);
            if ($manager->save())
                return $manager;
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