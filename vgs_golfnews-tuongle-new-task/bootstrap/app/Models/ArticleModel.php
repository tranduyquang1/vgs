<?php

namespace App\Models;

use App\Models\old\CateNewsModel;
use App\Models\Relations\ArticleRelationTrait;
use DB;

class ArticleModel extends AdminModel
{
    use ArticleRelationTrait;

    public function __construct()
    {
        $this->table = 'post';
        $this->folderUpload = 'post';
        $this->fieldSearchAccepted = ['name', 'content'];

        parent::__construct();
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == "admin-list-items") {
            $query = $this->select($this->table . '.*', 'c.name as category_name')
                ->leftJoin('cate_news as c', $this->table . '.category_id', '=', 'c.id');

            if ($params['filter']['status'] !== "all")
                $query->where($this->table . '.status', '=', $params['filter']['status']);

            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($this->table . '.' . $column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($this->table . '.' . $params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            if ($params['select']['value'] !== "" && $params['select']['value'] != 'default') {
                $query->where(function ($q) use ($params) {
                    $q->where($this->table . '.' . $params['select']['field'], '=', $params['select']['value']);
                    $cateModel = new CateNewsModel();
                    $childIds = $cateModel->getItem(['id' => $params['select']['value']], ['task' => 'get-child-by-parent']);
                    foreach ($childIds as $child) {
                        $q->orWhere($this->table . '.' . $params['select']['field'], '=', $child['id']);
                    }
                });
            }

            $result = $query->orderBy($this->table . '.id', 'desc')
                ->paginate($params['pagination']['totalItemsPerPage']);

        }

        return $result;
    }

    public function countItems($params = null, $options = null)
    {

        $result = null;

        if ($options['task'] == 'admin-count-items') {

            $query = $this::groupBy('status')
                ->select(DB::raw('status , COUNT(id) as count'));

            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            if ($params['select']['value'] !== "" && $params['select']['value'] != 'default') {
                $query->where(function ($q) use ($params) {
                    $q->where($params['select']['field'], '=', $params['select']['value']);
                    $cateModel = new CateNewsModel();
                    $childIds = $cateModel->getItem(['id' => $params['select']['value']], ['task' => 'get-child-by-parent']);
                    foreach ($childIds as $child) {
                        $q->orWhere($params['select']['field'], '=', $child['id']);
                    }
                });
            }

            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item') {
            $result = self::select()->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        $username = session('userInfo')['username'];
        $this->table = 'post';

        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'add-item') {
            $params['thumb'] = $this->uploadThumb($params['thumb']);

            $params['created_by'] = $username;
            $params['created'] = date('Y-m-d H:i:s');

            self::insert($this->prepareParams($params));
        }

        if ($options['task'] == 'edit-item') {
            if (!empty($params['thumb'])) {
                $this->deleteThumb($params['thumb_current']);
                $params['thumb'] = $this->uploadThumb($params['thumb']);
            }

            $params['modified_by'] = $username;
            $params['modified'] = date('Y-m-d H:i:s');

            self::where(['id' => $params['id']])->update($this->prepareParams($params));
        }
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $item = self::getItem($params, ['task' => 'get-thumb']);
            $this->deleteThumb($item['thumb']);
            self::where('id', $params['id'])->delete();
        }
    }
}

