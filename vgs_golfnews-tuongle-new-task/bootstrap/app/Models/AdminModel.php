<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class AdminModel extends Model
{

    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $table = '';
    protected $folderUpload = '';
    protected $fieldSearchAccepted = [
        'id',
        'name'
    ];

    protected $guarded = [];

    protected $crudNotAccepted = [
        '_token',
        'thumb_current',
        'image_current',
        'file_current',
        'show_title',
        'show_des',
        'key_value',
        'document',
        'image_main_alt'
    ];

    public function uploadThumb($thumbObj)
    {
        $thumbName = Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'zvn_storage_image');
        return $thumbName;
    }

    public function uploadFile($thumbObj)
    {
        $name = str_replace('.'.$thumbObj->clientExtension(), '', $thumbObj->getClientOriginalName());
        $thumbName = $name.'_'.Str::random(10) . '.' . $thumbObj->clientExtension();
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'zvn_storage_image');
        return $thumbName;
    }

    public function deleteThumb($thumbName)
    {
        Storage::disk('zvn_storage_image')->delete($this->folderUpload . '/' . $thumbName);
    }

    public function prepareParams($params)
    {
        return array_diff_key($params, array_flip($this->crudNotAccepted));
    }

}

