<?php

namespace App\Http\Controllers\Api\Manager;

use App\Endpoints\Manager\DeleteManager;
use App\Endpoints\Manager\IndexManager;
use App\Endpoints\Manager\UpdateManager;
use App\Http\Controllers\Api\Base\BaseController;
use App\Http\Endpoints\Manager\StoreManager;
use Illuminate\Http\Request;

/**
 * Class ManagerController
 * @package App\Http\Controllers\Api\Manager
 */
class ManagerController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return (new IndexManager($request))->index();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        return (new StoreManager($request))->storeManager();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        return (new UpdateManager($request))->updateManager($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request, $id)
    {
        return (new DeleteManager($request))->delete($id);
    }
}
