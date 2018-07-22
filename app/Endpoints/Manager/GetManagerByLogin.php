<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:10
 */

namespace App\Http\Endpoints\Manager;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;
use Illuminate\Http\Request;

class GetManagerByLogin extends BaseEndpoint
{
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function GetManagerByLogin()
    {
        $loginName = $this->request->input(Manager::DB_FILED_LOGIN_NAME);
        $password = $this->request->input(Manager::DB_FILED_PASSWORD);
        if (empty($loginName)) abort(400, "登录名为空！");
        if (empty($password)) abort(400, "密码为空！");
        $password = sha1($this->salt . $password);
        $manager = Manager::where(Manager::DB_FILED_LOGIN_NAME, $loginName)
            ->where(Manager::DB_FILED_PASSWORD, $password)
            ->first();

        return $manager;
    }
}