<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:04
 */

namespace App\Http\Endpoints\Wechat;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Wechat;
use Illuminate\Support\Facades\Auth;

/**
 * 添加公众号
 * Class StoreWechat
 * @package App\Http\Endpoints\Wechat
 */
class StoreWechat extends BaseEndpoint
{


    /**
     * @return Wechat|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeWechat()
    {
        $this->validate($this->request,$this->rules());

        $Wechat = new Wechat();
        $Wechat = $this->setAttribute($Wechat);
        if (is_null($Wechat->getAttribute(Wechat::DB_FILED_PASSWORD)))
            $password = "yd12345678";
        else
            $password = $Wechat->getAttribute(Wechat::DB_FILED_PASSWORD);

        $Wechat->setAttribute(Wechat::DB_FILED_PASSWORD, $password);
        $Wechat->save();
        $Wechat->setAttribute(Wechat::DB_FILED_LEVEL_MAP, Auth::user()->{Wechat::DB_FILED_LEVEL_MAP} . "," . $Wechat->getKey());
        $Wechat->save();

        if ($Wechat)
            return $this->resultForApi(200, $Wechat);
        else
            return $this->resultForApi(400, [], "操作失败");
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules() {

        return [
            Wechat::DB_FILED_NAME => 'required',
            Wechat::DB_FILED_LOGIN_NAME => 'required|alpha_num|between:6,16|unique:' . Wechat::TABLE_NAME,
            Wechat::DB_FILED_TYPE => 'required',
            Wechat::DB_FILED_STATE => '',
            Wechat::DB_FILED_OA_WECHAT_ID => '',
            Wechat::DB_FILED_PARENT_ID => '',
            Wechat::DB_FILED_PHONE => 'required',
            Wechat::DB_FILED_EMAIL => 'email',
            Wechat::DB_FILED_QQ => 'numeric',
            Wechat::DB_FILED_WECHAT_NUMBER => 'alpha_num'
        ];
    }
}

