<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 11:03
 */

namespace App\Http\Endpoints\Base;


class BaseEndpoint
{
    protected $salt;
    public function __construct()
    {
        $this->salt = "morewechatsalt";
    }
}