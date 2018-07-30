<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:04
 */

namespace App\Http\Endpoints\Manager;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;


/**
 * 添加用户
 * Class StoreManager
 * @package App\Http\Endpoints\Manager
 */
class StoreManager extends BaseEndpoint
{


    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeManager()
    {
        $this->validate($this->request,$this->rules());

        $manager = new Manager();
        $manager = $this->setAttribute($manager);
        if (is_null($manager->getAttribute(Manager::DB_FILED_PASSWORD)))
            $password = "yd12345678";
        else
            $password = $manager->getAttribute(Manager::DB_FILED_PASSWORD);

        $manager->setAttribute(Manager::DB_FILED_PASSWORD, $password);
        $manager->setAttribute(Manager::DB_FILED_PARENT_ID, Auth::user()->getKey());
        $manager->save();
        $manager->setAttribute(Manager::DB_FILED_LEVEL_MAP, Auth::user()->{Manager::DB_FILED_LEVEL_MAP} . "," . $manager->getKey());
        $manager->save();

        if ($manager)
            return $this->resultForApi(200, $manager);
        else
            return $this->resultForApi(400, [], "操作失败");
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules() {

        return [
            Manager::DB_FILED_NAME => 'required',
            Manager::DB_FILED_LOGIN_NAME => 'required|alpha_num|between:6,16|unique:' . Manager::TABLE_NAME,
            Manager::DB_FILED_TYPE => 'required',
            Manager::DB_FILED_STATE => '',
            Manager::DB_FILED_OA_WECHAT_ID => '',
            Manager::DB_FILED_PARENT_ID => '',
            Manager::DB_FILED_PHONE => 'required',
            Manager::DB_FILED_EMAIL => 'email',
            Manager::DB_FILED_QQ => 'numeric',
            Manager::DB_FILED_WECHAT_NUMBER => ''
        ];
    }
}

