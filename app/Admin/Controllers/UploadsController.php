<?php


namespace App\Admin\Controllers;

use Dcat\Admin\Traits\HasUploadedFile;

/**
 * Class UploadsController
 * @package App\Admin\Controllers
 * 自定义后台上传接口
 */
class UploadsController
{
    use HasUploadedFile;

    public function handle()
    {
        //  获取后台上传 disk 配置
        $disk = $this->disk();

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }

        $file = $this->file();

        //  定义目录名
        $dir = 'my-shop';

        $newName = md5(uniqid()).'.'.$file->getClientOriginalExtension();

        $result = $disk->putFileAs($dir, $file, $newName);

        $baseUrl = config('filesystems.disks.qiniu.url');

        $path = $baseUrl. $dir . '/' .$newName;

        return $result
            ? $this->responseUploaded($path, $disk->url($path))
            : $this->responseErrorMessage('文件上传失败');
    }

}
