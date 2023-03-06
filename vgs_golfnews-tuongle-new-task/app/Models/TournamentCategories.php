<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\BannersCategories;
use App\Models\BannersCategory;

class TournamentCategories extends AdminModel
{
    // use NodeTrait;
    protected $table = 'tournament_categories';
    protected $searchAccepted = ['name', 'id'];
    protected $fieldSearchAccepted = [
        'id',
        'name'
    ];
    protected $fillable = ['id','name','status','is_home','multi_language','amount_slider_posts','meta_title','meta_description','meta_keyword','banner_category_id','logo_web_icon','logo_seo','logo_menu','menu_background_color','site_background_color','logo_home','google_analytics'];
    protected $crudNotAccepted = ['_token', 'thumb_current','logo_web_icon_current','logo_seo_current','logo_menu_current','logo_home_current', 'q'];



    public $timestamps =true;
    // public function bannerCategories()
    // {
    //     return $this->hasManyThrough(BannersCategories::class, BannersCategory::class,'id','banner_category_id');
    // }
    public function getAdmincountItems($params, $isMobile = false)
    {
        $query = $this::groupBy('status')
            ->select(DB::raw('status , COUNT(id) as count'));
 
        

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
        $params['logo_menu'] = $this->uploadThumb($params['logo_menu']);
        $params['logo_home'] = $this->uploadThumb($params['logo_home']);
        $params['logo_web_icon'] = $this->uploadThumb($params['logo_web_icon']);
        if(array_key_exists('logo_seo',$params))
        $params['logo_seo'] = $this->uploadThumb($params['logo_seo']);
        $this->create($params);
    }

    public function updateItem($params) {
        $params['updated_by'] = @session('userInfo')['id'];
        if (@$params['logo_menu']) {
            $params['logo_menu'] = $this->uploadThumb($params['logo_menu']);
            $this->deleteThumb($params['logo_menu_current']);
        }
        if (@$params['logo_web_icon']) {
            $params['logo_web_icon'] = $this->uploadThumb($params['logo_web_icon']);
            $this->deleteThumb($params['logo_web_icon_current']);
        }
        if (@$params['logo_home']) {
            $params['logo_home'] = $this->uploadThumb($params['logo_home']);
            $this->deleteThumb($params['logo_home_current']);
        }
        if (@$params['logo_seo']) {
            $params['logo_seo'] = $this->uploadThumb($params['logo_seo']);
            $this->deleteThumb($params['logo_menu_current']);
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