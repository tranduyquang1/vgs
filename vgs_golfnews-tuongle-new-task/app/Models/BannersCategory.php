<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\DB;

class BannersCategory extends AdminModel
{
    // use NodeTrait;
    protected $table = 'banners_category';
    protected $searchAccepted = ['name', 'id'];
    protected $fieldSearchAccepted = [
        'id',
        'name'
    ];
    protected $fillable = ['id','name','status'];
    public $timestamps =true;
    protected $crudNotAccepted = ['_token', 'thumb_current', 'q'];

    public function getAdmincountItems($params)
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
        $this->create($params);
    }

    public function updateItem($params) {
        $params['updated_by'] = @session('userInfo')['id'];
        $this->where('id', $params['id'])->update($this->prepareParams($params));
    }
}