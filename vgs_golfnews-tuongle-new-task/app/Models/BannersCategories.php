<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BannersCategories extends AdminModel
{
    // use NodeTrait;
    protected $table = 'banners_categories';
    protected $searchAccepted = ['name', 'id'];
    protected $fieldSearchAccepted = [
        'id',
        'name'
    ];
    protected $fillable = ['id','name','thumb','url','type','position','category_id','status','device','is_mobile','last_viewed_at','viewed_count','clicked_count','created_by','updated_by','is_post','is_category','is_home'];
    protected $crudNotAccepted = ['_token', 'thumb_current', 'q'];



    public $timestamps =true;
    public function getAdmincountItems($params, $isMobile = false)
    {
        $query = $this::groupBy('status')
            ->select(DB::raw('status , COUNT(id) as count'));
 
        if($params['filter']['is_mobile'] !==""){
            $query->where('is_mobile',$params['filter']['is_mobile']);
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
    public function getAdminList($params)
    {
        $query = $this->select();


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

        if (isset($params['filter']['category_id']) && $params['filter']['category_id'] !== "default") {
            $query->where('category_id', $params['filter']['category_id']);

        }

        if (isset($params['filter']['position']) && $params['filter']['position'] !== "default") {
            $query->where('position', $params['filter']['position']);
        }

  

        if (isset($params['filter']['is_mobile']) && $params['filter']['is_mobile'] !== "default") {
            $query->where('is_mobile', $params['filter']['is_mobile']);
        }

        return $query->orderBy('created_at')->paginate($params['pagination']['totalItemsPerPage']);
    }
    public function scopeMobile($query)
    {
        return $query->where('is_mobile', 1);
    }

    public function scopeNotMobile($query)
    {
        return $query->where('is_mobile', 0);
    }
    public function storeItem($params) {
        $params['created_by'] = @session('userInfo')['id'];
        $params['updated_by'] = @session('userInfo')['id'];
        $params['thumb'] = $this->uploadThumb($params['thumb']);
        $this->create($params);
    }

    public function updateItem($params) {
        $params['updated_by'] = @session('userInfo')['id'];
        $params['is_home'] = @$params['is_home'] ? 1: 0;
        $params['is_category'] = @$params['is_category'] ? 1: 0;
        $params['is_post'] = @$params['is_post'] ? 1: 0;
        if (@$params['thumb']) {
            $params['thumb'] = $this->uploadThumb($params['thumb']);
            $this->deleteThumb($params['thumb_current']);
        }
        $this->where('id', $params['id'])->update($this->prepareParams($params));
    }

    public function uploadThumb($thumbObj, $width = null)
    {
        $thumbName = Str::random() . '.' . $thumbObj->clientExtension();

        $thumbObj->storeAs($this->folderUpload, $thumbName, 'zvn_storage_image');
        return "/images/$this->folderUpload/$thumbName";

    }
}