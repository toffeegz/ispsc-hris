<?php

namespace App\Services\Utils\File;

use App\Services\Utils\File\FileServiceInterface;
use Illuminate\Support\Facades\Storage;

class FileService implements FileServiceInterface
{
    private $basePath;
    public function  __construct(

    ) {
        $this->basePath = config('storage.base_path');
    }

    public function download($folderName, $fileName)
    {
        $path = $this->basePath . $folderName ."/" . $fileName;
        return Storage::disk('s3')->download($path);
    }

    public function upload($folderName, $fileName, $file)
    {
        $fileName = $fileName . "." . $file->getClientOriginalExtension();
        $folderName = $this->basePath . $folderName;
        $result = Storage::disk('s3')->putFileAs($folderName, $file, $fileName);
        return $result;
    }

    public function uploadAndGetUrl($folderName, $fileName, $file)
    {
        $result = $this->upload($folderName, $fileName, $file);
        $url = Storage::disk('s3')->url($result);
        return $url;
    }
}