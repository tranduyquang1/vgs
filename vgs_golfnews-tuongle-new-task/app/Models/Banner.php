<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class Banner extends AdminModel
{
    protected $searchAccepted = ['name', 'url'];
    protected $fillable = ['name', 'url', 'page', 'position', 'status', 'thumb', 'is_mobile', 'type', 'created_by', 'updated_by', 'is_home', 'is_category', 'is_post'];
    protected $crudNotAccepted = ['_token', 'thumb_current', 'q'];
    protected $folderUpload = 'banner';

    public function getAdminList($params, $isMobile = false)
    {
        $query = $this->select();

        if ($isMobile) {
            $query->mobile();
        } else {
            $query->notMobile();
        }

        if ($params['filter']['status'] !== "all") {
            $query->where('status', '=', $params['filter']['status']);
        }

        if ($params['search']['value'] !== "") {
            if ($params['search']['field'] == "all") {
                $query->where(function ($query) use ($params) {
                    foreach ($this->searchAccepted as $column) {
                        $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                    }
                });
            } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
            }
        }

        if (isset($params['filter']['page']) && $params['filter']['page'] !== "default") {
            switch ($params['filter']['page']) {
                case 'home':
                    $query->home();
                    break;
                case 'category':
                    $query->category();
                    break;
                case 'post':
                    $query->post();
                    break;
            }
        }

        if (isset($params['filter']['type']) && $params['filter']['type'] !== "default") {
            $query->where('type', $params['filter']['type']);
        }

        if (isset($params['filter']['position']) && $params['filter']['position'] !== "default") {
            $query->where('position', $params['filter']['position']);
        }

        if (isset($params['filter']['is_mobile']) && $params['filter']['is_mobile'] !== "default") {
            $query->where('is_mobile', $params['filter']['is_mobile']);
        }

        return $query->orderBy('position')->orderBy('type')->paginate($params['pagination']['totalItemsPerPage']);
    }

    public function getAdmincountItems($params, $isMobile = false)
    {
        $query = $this::groupBy('status')
            ->select(DB::raw('status , COUNT(id) as count'));

        if ($isMobile) {
            $query->mobile();
        } else {
            $query->notMobile();
        }

        if ($params['search']['value'] !== "") {
            if ($params['search']['field'] == "all") {
                $query->where(function ($query) use ($params) {
                    foreach ($this->searchAccepted as $column) {
                        $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                    }
                });
            } else if (in_array($params['search']['field'], $this->searchAccepted)) {
                $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
            }
        }

        return $query->get()->toArray();
    }

    public function storeItem($params) {
        $params['created_by'] = @session('userInfo')['id'];
        $params['updated_by'] = @session('userInfo')['id'];
        $params['is_home'] = @$params['is_home'] ? 1: 0;
        $params['is_category'] = @$params['is_category'] ? 1: 0;
        $params['is_post'] = @$params['is_post'] ? 1: 0;
        $params['thumb'] = $this->uploadThumb($params['thumb']);
        $this->create($params);
    }

    public function updateItem($params) {
        $params['updated_by'] = @session('userInfo')['id'];
        if (@$params['thumb']) {
            $params['thumb'] = $this->uploadThumb($params['thumb']);
            $this->deleteThumb($params['thumb_current']);
        }
        $params['is_home'] = @$params['is_home'] ? 1: 0;
        $params['is_category'] = @$params['is_category'] ? 1: 0;
        $params['is_post'] = @$params['is_post'] ? 1: 0;
        if (!empty($params['type'])) $params['is_mobile'] = 1;
        $this->where('id', $params['id'])->update($this->prepareParams($params));
    }

    public function uploadThumb($thumbObj, $width = null)
    {
        $thumbName = Str::random() . '.' . $thumbObj->clientExtension();
//        $imgFile = Image::make($thumbObj->getRealPath());
//        $imgFile->fit(1280, 720, function ($constraint) {
//            $constraint->upsize();
//        })->save("images/$this->folderUpload/$thumbName");
        $thumbObj->storeAs($this->folderUpload, $thumbName, 'zvn_storage_image');
        return "/images/$this->folderUpload/$thumbName";

    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeHome($query)
    {
        return $query->where('is_home', 1);
    }

    public function scopeCategory($query)
    {
        return $query->where('is_category', 1);
    }

    public function scopePost($query)
    {
        return $query->where('is_post', 1);
    }

    public function scopeSidebar1($query)
    {
        return $query->where('position', 'sidebar1');
    }

    public function scopeSidebar2($query)
    {
        return $query->where('position', 'sidebar2');
    }

    public function scopeSidebar3($query)
    {
        return $query->where('position', 'sidebar3');
    }

    public function scopeCenter($query)
    {
        return $query->where('position', 'center');
    }

    public function scopeMobile($query)
    {
        return $query->where('is_mobile', 1);
    }

    public function scopeNotMobile($query)
    {
        return $query->where('is_mobile', 0);
    }

    public function scopeTopBanner($query)
    {
        return $query->where('type', 'top_banner');
    }
}
