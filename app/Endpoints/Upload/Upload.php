<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/8/6
 * Time: 14:44
 */

namespace App\Endpoints\Upload;


use App\Http\Endpoints\Base\BaseEndpoint;
use Illuminate\Support\Facades\Storage;

class Upload extends BaseEndpoint
{
    public function upload()
    {
        $file = $this->request->file('file');
        // 文件是否上传成功
        if ($file->isValid()) {
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $type = $file->getClientMimeType();     // image/jpeg
            // 上传文件
            $filename = date('YmdHis') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
            dd($bool);
        }
    }
}