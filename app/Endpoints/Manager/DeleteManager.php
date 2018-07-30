<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:41
 */

namespace App\Endpoints\Manager;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;

/**
 * 删除用户
 * Class DeleteManager
 * @package App\Endpoints\Manager
 */
class DeleteManager extends BaseEndpoint
{
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(int $id){
        $manager = (new Manager())->find($id);
        if ($manager instanceof Manager) {
            if (!$this->verifyOperationPermissions($manager))
                return $this->resultForApi(400, [], "非法操作");

            if (Manager::destroy($id)) return $this->resultForApi(200, $id);
            else
                return $this->resultForApi(400, [], "操作失败");
        } else {
            return $this->resultForApi(400, [], "信息不存在");
        }

    }
}