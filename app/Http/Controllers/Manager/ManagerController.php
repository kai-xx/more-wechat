<?php

namespace App\Http\Controllers\Manager;

use App\Endpoints\Manager\DeleteManager;
use App\Endpoints\Manager\IndexManager;
use App\Endpoints\Manager\UpdateManager;
use App\Http\Controllers\Base\BaseController;
use App\Http\Endpoints\Manager\StoreManager;
use Illuminate\Http\Request;

class ManagerController extends BaseController
{
    public function index(Request $request)
    {
        return (new IndexManager($request))->index();
    }
    public function store(Request $request)
    {
        return (new StoreManager($request))->storeManager();
    }

    public function update(Request $request, $id)
    {
        return (new UpdateManager($request))->updateManager($id);
    }

    public function delete(Request $request, $id)
    {
        return (new DeleteManager($request))->delete($id);
    }
}
