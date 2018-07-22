<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午1:41
 */

namespace App\Endpoints\Manager;


use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;

class DeleteManager extends BaseEndpoint
{
    public function delete(int $id){
        return Manager::destroy($id);
    }
}