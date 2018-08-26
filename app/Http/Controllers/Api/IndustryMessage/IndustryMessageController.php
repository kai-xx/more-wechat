<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/8/26
 * Time: 上午11:21
 */

namespace App\Http\Controllers\Api\IndustryMessage;


use App\Endpoints\IndustryMessage\GetTemplateList;
use App\Endpoints\IndustryMessage\IndexIndustry;
use App\Endpoints\IndustryMessage\SendLog;
use App\Endpoints\IndustryMessage\ShowIndustryMessage;
use App\Endpoints\IndustryMessage\StoreIndustryMessage;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

class IndustryMessageController extends BaseController
{
    public function index(Request $request) {
        return (new IndexIndustry($request))->index();
    }

    public function sendLog(Request $request) {
        return (new SendLog($request))->index();
    }

    public function update(Request $request, $id)
    {
        return (new StoreIndustryMessage($request))->addIndustryMessage($id);
    }

    public function show(Request $request, $id)
    {
        return (new ShowIndustryMessage($request))->showMessage($id);
    }

}