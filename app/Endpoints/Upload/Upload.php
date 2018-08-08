<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/8/6
 * Time: 14:44
 */

namespace App\Endpoints\Upload;


use App\Http\Endpoints\Base\BaseEndpoint;

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
            if (!$this->verifyFileType($type)) return $this->resultForApi(400,[],"文件类型非法！");
            // 上传文件
            $filename = date('YmdHis') . '-' . uniqid() . '.' . $ext;
            // 使用我们新建的uploads本地存储空间（目录）
            $savePath ='./uploads/' . date("Ymd") . "/";
            $result = $file->move($savePath , $filename);
            return $this->resultForApi(200, [
                'tmpPath' => $this->absolutePath($result->getPathname()),
                'savePath' => $result->getPathname(),
                'filename' => $result->getFilename()
            ], '');
        } else {
            return $this->resultForApi(400,[],"文件上传失败！");
        }
    }

    private function verifyFileType($type) {
        $verify = [
            "image/jpeg",
            "image/jpg",
            "image/png",
            "image/gif"
        ];
        return in_array($type, $verify);
    }
}