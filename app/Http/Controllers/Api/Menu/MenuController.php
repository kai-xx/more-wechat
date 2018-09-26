<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 16:34
 */

namespace App\Http\Controllers\Api\Menu;


use App\Endpoints\Menu\DeleteMenu;
use App\Endpoints\Menu\IndexMenu;
use App\Endpoints\Menu\ShowMenu;
use App\Endpoints\Menu\StoreMenu;
use App\Endpoints\News\UpdateMenu;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

/**
 * 菜单
 * Class MenuController
 * @package App\Http\Controllers\Api\Menu
 */
class MenuController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        return (new IndexMenu($request))->index();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) {
        return (new StoreMenu($request))->storeMenu();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        return (new UpdateMenu($request))->updateMenu($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id) {
        return (new ShowMenu($request))->showMenu($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request, $id) {
        return (new DeleteMenu($request))->delete($id);
    }
}