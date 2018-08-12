<?php
define("appid", "wxd37089c29661b138");
define("secret", "65d6a5e0e92c4be58edb44ebc71f2270");
function getToken(){
    $url = "https://api.weixin.qq.com/cgi-bin/token";
    $data = [
	"grant_type" => "client_credential",
	"appid" => appid,
	"secret" => secret
    ];
    return http_send("GET",$url,$data);
}
function http_send($type,$url,$data, $header = []){
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
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header); //添加自定义的http header
 
    //执行并获取url地址的内容
    $output = curl_exec($ch);
    $errorCode = curl_errno($ch);
    //释放curl句柄
    curl_close($ch);
    return $output;
}
function getAllFans($token){
    $url = "https://api.weixin.qq.com/cgi-bin/user/get";
    $data = [
        "access_token" => $token,
        "next_openid" => ""
    ];
    return http_send("GET", $url, $data);
}
function sendMessageByText($token, $openId, $text){
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
    $data = json_encode($data,JSON_UNESCAPED_UNICODE);
    return http_send("POST", $url, $data, $header);
}
function sendMessageByNews($token, $openId, $news) {
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
    return http_send("POST", $url, $data, $header);
}
function getUserInfo($token, $openId){
    $url = "https://api.weixin.qq.com/cgi-bin/user/info";
    $data = [
        "access_token" => $token,
	"openid" => $openId
    ];
    return http_send("GET", $url, $data);
}
$token = json_decode(getToken(),true)['access_token'];
$openIds = json_decode(getAllFans($token),ture)['data']['openid'];
print_r($openIds);exit;
foreach($openIds as $key=>$openId) {
$check = [
"oi_8o0ryWthzQ4zjCZSWHFaapZtM",
"oi_8o0oZWk3j6xrcM_hqF7zGW9SE",
"oi_8o0q6kHP2DKzSL1aP891WgFD8"
];

if (!in_array($openId,$check)) continue;
	//发送文字
    $text = "测试文字推送";
    sendMessageByText($token, $openId, $text);
    $news = [
        [
            "title" => "测试图文",
            "description" => "图文描述信息",
            "url" => "https://www.baidu.com",
            "picurl" => "https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/c0%3Dbaike116%2C5%2C5%2C116%2C38/sign=43ccddd4918fa0ec6bca6c5f47fe328b/6a600c338744ebf83b507bd8d9f9d72a6059a737.jpg"
        ],
        [
            "title" => "测试图文",
            "description" => "图文描述信息",
            "url" => "https://www.baidu.com",
            "picurl" => "https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/c0%3Dbaike116%2C5%2C5%2C116%2C38/sign=43ccddd4918fa0ec6bca6c5f47fe328b/6a600c338744ebf83b507bd8d9f9d72a6059a737.jpg"
        ],[
            "title" => "测试图文",
            "description" => "图文描述信息",
            "url" => "https://www.baidu.com",
            "picurl" => "https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/c0%3Dbaike116%2C5%2C5%2C116%2C38/sign=43ccddd4918fa0ec6bca6c5f47fe328b/6a600c338744ebf83b507bd8d9f9d72a6059a737.jpg"
        ],[
            "title" => "测试图文",
            "description" => "图文描述信息",
            "url" => "https://www.baidu.com",
            "picurl" => "https://gss1.bdstatic.com/9vo3dSag_xI4khGkpoWK1HF6hhy/baike/c0%3Dbaike116%2C5%2C5%2C116%2C38/sign=43ccddd4918fa0ec6bca6c5f47fe328b/6a600c338744ebf83b507bd8d9f9d72a6059a737.jpg"
        ]

    ];
    $resultNews = sendMessageByNews($token, $openId, $news);
    var_dump(getUserInfo($token,$openId));
    var_dump($resultNews);

}
echo $token;
?>
