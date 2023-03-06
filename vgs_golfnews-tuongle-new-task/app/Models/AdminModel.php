<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class AdminModel extends Model
{
    protected $folderUpload = '';

    public function uploadThumb($thumbObj, $width = null)
    {
        $thumbName = Str::random();
        if (!empty($width)) $thumbName .= "_$width";
        $thumbName .= '.' . $thumbObj->clientExtension();
        $imgFile = Image::make($thumbObj->getRealPath());
        $imgFile->resize($width ?? 1920, 720, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path("images/$this->folderUpload/$thumbName"));
//        $thumbObj->storeAs($this->folderUpload, $thumbName, 'zvn_storage_image');
//        return $thumbName;
        return "/images/$this->folderUpload/$thumbName";
    }

    public function uploadMedia($thumbObj)
    {
        $name = time() . '_' . Str::random() . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $name, 'zvn_storage_media');
        return "/media/{$this->folderUpload}/{$name}";
    }

    public function uploadFile($thumbObj)
    {
        $name = str_replace('.' . $thumbObj->clientExtension(), '', $thumbObj->getClientOriginalName());
        $thumbName = $name . '_' . Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'zvn_storage_image');
        return $thumbName;
    }

    public function deleteThumb($thumb)
    {
        Storage::disk('zvn_storage')->delete($thumb);
    }

    public function prepareParams($params)
    {
        return array_diff_key($params, array_flip($this->crudNotAccepted));
    }

}

