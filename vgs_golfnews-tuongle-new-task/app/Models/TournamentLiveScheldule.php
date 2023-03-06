<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\BannersCategories;
use App\Models\BannersCategory;

class TournamentLiveScheldule extends AdminModel
{
    // use NodeTrait;
    protected $table = 'tournament_scheldule_live';
    protected $searchAccepted = ['name', 'id'];
    protected $fieldSearchAccepted = [
        'id',
        'name'
    ];
    protected $fillable = ['id','name','status','tournament_categories_id','date','time','activities','language','order'];
    protected $crudNotAccepted = ['_token', 'image_current', 'q'];



    public $timestamps =false;

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

        if (isset($params['filter']['tournament_categories_id']) && $params['filter']['tournament_categories_id'] !== "default") {
            $query->where('tournament_categories_id', $params['filter']['tournament_categories_id']);

        }

        if (isset($params['filter']['type']) && $params['filter']['type'] !== "default") {
            $query->where('type', $params['filter']['type']);
        }

  

       

        return $query->orderBy('order')->paginate($params['pagination']['totalItemsPerPage']);
    }

    public function storeItem($params) {
        $params['created_by'] = @session('userInfo')['id'];
        $params['updated_by'] = @session('userInfo')['id'];

        if(array_key_exists('image',$params))
        $params['image'] = $this->uploadThumb($params['image']);
        $this->create($params);
    }

    public function updateItem($params) {
        // $params['updated_by'] = @session('userInfo')['id'];
        if (@$params['image']) {
            $params['image'] = $this->uploadThumb($params['image']);
            $this->deleteThumb($params['image_current']);
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