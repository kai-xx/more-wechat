<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Models\Manager::class, function (Faker\Generator $faker) {
    //字符串
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";

    //1.获取字符串的长度
    $length = strlen($str)-1;

    //2.字符串截取开始位置
    $start = rand(0,$length);

    //3.字符串截取长度
    $count = rand(5,$length);

    //4.随机截取字符串，取其中的一部分字符串
    $name = substr($str, $start,$count);
    $phone = "177".substr(time(), -4). sprintf("%04d", rand(1,9999));
    return [
        \App\Models\Manager::DB_FILED_LOGIN_NAME => $phone,
        \App\Models\Manager::DB_FILED_NAME => $name,
        \App\Models\Manager::DB_FILED_PASSWORD => \Illuminate\Support\Facades\Hash::make(12345678),
        \App\Models\Manager::DB_FILED_PHONE => $phone,
        \App\Models\Manager::DB_FILED_TYPE => rand(1,3)
    ];
});
