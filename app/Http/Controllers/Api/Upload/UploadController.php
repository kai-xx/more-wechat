<?php

namespace App\Http\Controllers\Api\Upload;


use App\Endpoints\Upload\Upload;
use App\Http\Controllers\Api\Base\BaseController;
use Illuminate\Http\Request;

class UploadController extends BaseController
{
    //
    public function upload(Request $request)
    {
        return (new Upload($request))->upload();
    }
}
