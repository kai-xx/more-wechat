<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/4
 * Time: 下午8:18
 */

namespace App\Endpoints\WechatApi;


use App\Http\Endpoints\Base\BaseEndpoint;
use Illuminate\Support\Facades\Redis;

/**
 * 微信api的所有请求
 * Class BaseApi
 * @package App\Endpoints\WechatApi
 */
class BaseApi extends BaseEndpoint
{
    /**
     * @var string
     */
    protected $wechatToken = "";

    /**
     * 获取token
     * token会记录在redis中(7000s后失效)
     * @param $appid
     * @param $secret
     * @return mixed
     */
    protected function getToken($appid, $secret){
        $token = Redis::get($appid);
        if ( $token ) return $this->wechatToken = $token;
        $url = "https://api.weixin.qq.com/cgi-bin/token";
        $data = [
            "grant_type" => "client_credential",
            "appid" => $appid,
            "secret" => $secret
        ];
        $result = $this->http_send("GET",$url,$data);
        if (is_object($result)) return $result;
        $this->wechatToken = $result['access_token'];
        return Redis::setex($appid, 7000 ,$this->wechatToken);
    }

    /**
     * 通过openId获取用户信息
     * @param $token
     * @param $openId
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    protected function getUserInfo($token, $openId)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info";
        $data = [
            "access_token" => $token,
            "openid" => $openId
        ];
        return $this->http_send("GET", $url, $data);
    }

    /**
     * 根据openIds批量获取用户信息
     * @param $token
     * @param array $filter
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    protected function batchGetUserInfo($token, array $filter) {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=" . $token;
        $data = [
            "user_list" => $filter
        ];
        $header = [
            "Accept:application/json",
            "Content-Type:application/json;charset=utf-8"
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        return $this->http_send("POST", $url, $data, $header);
    }
    /**
     * 获取fans
     * @param $token
     * @param string $nextId
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    protected function getFans($token, $nextId = "")
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/get";
        $data = [
            "access_token" => $token,
            "next_openid" => $nextId
        ];
        return $this->http_send("GET", $url, $data);

    }
    protected function sendMessageByText($token, $openId, $text){
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $token;
        $data = [
            "touser" => $openId,
            "msgtype" => "text",
            "text" => [
                "content" => $text
            ]
        ];
        $header = [
            "Accept:application/json",
            "Content-Type:application/json;charset=utf-8"
        ];
        return $this->http_send("POST", $url, $data, $header);
    }
    protected function sendMessageByNews($token, $openId, $news) {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $token;
        $data = [
            "touser" => $openId,
            "msgtype" => "news",
            "news" => [
                "articles" => $news
            ]
        ];
        $header = [
            "Accept:application/json",
            "Content-Type:application/json;charset=utf-8"
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        return $this->http_send("POST", $url, $data, $header);
    }
    protected function http_send($type,$url,$data, $header = []){
        app('log')->info("请求微信的URL " . $url);
        app('log')->info("请求微信数据", is_array($data) ? $data : json_decode($data, true));
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, "$url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_TIMEOUT,5); //定义超时3秒钟
        if ($type == "POST") {
            // POST数据
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        if (empty($header)) {
            $data = http_build_query($data);
        }
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  //所需传的数组用http_bulid_query()函数处理一下，就ok了
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); //添加自定义的http header

        //执行并获取url地址的内容
        $output = curl_exec($ch);
        $errorCode = curl_errno($ch);
        //释放curl句柄
        curl_close($ch);

        app('log')->info("请求微信返回的数据 " . $output);
        $result = json_decode($output,true);
        if (empty($result)) $this->resultForApi(400,[],'微信对接异常');
        if (isset($result['errcode']) && $result['errcode'] == 40164) return $this->resultForApi(400,[],'服务器IP未在白名单中');
        return $result;
    }
}