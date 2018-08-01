<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:04
 */

namespace App\Endpoints\Wechat;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\OaWechat;
use Illuminate\Support\Facades\Auth;

/**
 * 添加公众号
 * Class StoreWechat
 * @package App\Http\Endpoints\Wechat
 */
class StoreWechat extends BaseEndpoint
{


    /**
     * @return OaWechat|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeWechat()
    {
        $this->validate($this->request,$this->rules());

        $wechat = new OaWechat();
        $wechat = $this->setAttribute($wechat);
        $wechat->setAttribute(OaWechat::DB_FILED_MANAGER_ID, Auth::user()->getKey());
        $wechat->setAttribute(OaWechat::DB_FILED_STATE, OaWechat::STATE_OPEN);
        $wechat->save();

        if ($wechat)
            return $this->resultForApi(200, $wechat);
        else
            return $this->resultForApi(400, [], "操作失败");
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules() {

        return [
            OaWechat::DB_FILED_LINKMAN        => 'required',
            OaWechat::DB_FILED_PHONE          => 'required',
            OaWechat::DB_FILED_NAME           => 'required',
            OaWechat::DB_FILED_ORIGINAL_ID    => 'required',
            OaWechat::DB_FILED_WECHAT_NUMBER  => 'required|alpha_num',
            OaWechat::DB_FILED_APP_ID         => 'required',
            OaWechat::DB_FILED_APP_SECRET     => 'required|alpha_num',
            OaWechat::DB_FILED_TYPE           => 'required|numeric',
            OaWechat::DB_FILED_IMAGE          => 'required',
        ];
    }
}

