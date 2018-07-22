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
                return response()->json([
                    'error' => '非法操作！'
                ], 400);

            if (Manager::destroy($id)) return $id;
            else
                return response()->json([
                    'error' => '操作失败！'
                ], 400);
        } else {
            return response()->json([
                'error' => '信息失败！'
            ], 400);
        }

    }
}