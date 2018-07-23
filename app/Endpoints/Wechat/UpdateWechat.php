<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:39
 */

namespace App\Endpoints\Wechat;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Wechat;

/**
 * 编辑公众号
 * Class UpdateWechat
 * @package App\Endpoints\Wechat
 */
class UpdateWechat extends BaseEndpoint
{
    /**
     * @return Wechat Wechat
     */
    public function Wechat() {
        return new Wechat();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateWechat(int $id)
    {
        $this->validate($this->request,$this->rules());

        $Wechat = $this->Wechat()->find($id);
        if ($Wechat instanceof Wechat) {

            if (!$this->verifyOperationPermissions($Wechat))
                return  $this->resultForApi(400, '非法操作');

            $Wechat = $this->setAttribute($Wechat);
            if ($Wechat->save())
                return $Wechat;
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
            Wechat::DB_FILED_NAME => '',
            Wechat::DB_FILED_LOGIN_NAME => 'alpha_num|between:6,16|unique:' . Wechat::TABLE_NAME,
            Wechat::DB_FILED_TYPE => '',
            Wechat::DB_FILED_STATE => '',
            Wechat::DB_FILED_OA_WECHAT_ID => '',
            Wechat::DB_FILED_PARENT_ID => '',
            Wechat::DB_FILED_PHONE => '',
            Wechat::DB_FILED_EMAIL => 'email',
            Wechat::DB_FILED_QQ => 'numeric',
            Wechat::DB_FILED_WECHAT_NUMBER => 'alpha_num'
        ];
    }
}