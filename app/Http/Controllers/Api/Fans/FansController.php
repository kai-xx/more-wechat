<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 16:33
 */

namespace App\Http\Controllers\Api\Fans;


use App\Endpoints\Fans\IndexFans;
use App\Endpoints\Fans\IndexTags;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

class FansController extends BaseController
{
    public function index(Request $request)
    {
        return (new IndexFans($request))->index();
    }

    public function tagList(Request $request)
    {
        return (new IndexTags($request))->index();
    }

}