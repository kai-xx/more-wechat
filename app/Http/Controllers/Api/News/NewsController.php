<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/30
 * Time: 16:34
 */

namespace App\Http\Controllers\Api\News;


use App\Endpoints\News\DeleteNews;
use App\Endpoints\News\IndexNews;
use App\Endpoints\News\ShowNews;
use App\Endpoints\News\StoreNews;
use App\Endpoints\News\UpdateNews;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

/**
 * Class NewsController
 * @package App\Http\Controllers\Api\News
 */
class NewsController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        return (new IndexNews($request))->index();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        return (new StoreNews($request))->storeNews();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        return (new UpdateNews($request))->updateNews($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        return (new ShowNews($request))->showNews($id);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function delete(Request $request, $id)
    {
        return (new DeleteNews($request))->delete($id);
    }

}