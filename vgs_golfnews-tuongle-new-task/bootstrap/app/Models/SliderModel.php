<?php

namespace App\Models;

use DB;

class SliderModel extends AdminModel
{
    public function __construct()
    {
        $this->table = 'slider';
        $this->folderUpload = 'slider';
        $this->fieldSearchAccepted = ['id', 'name', 'description', 'link'];

        parent::__construct();
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == "admin-list-items") {
            $query = $this->select();

            if ($params['filter']['status'] !== "all") {
                $query->where('status', '=', $params['filter']['status']);
            }

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

            $result = $query->orderBy('sort', 'asc')
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

        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'add-item') {
            self::where('id', '>', 0)->increment('sort');
            $params['sort'] = 1;
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

            self::where('id', $params['id'])->update($this->prepareParams($params));
        }
    }

    public function ordering($params = null, $options = null)
    {
        $itemCurrent = $this->getItem(['id' => $params['id_current']], ['task' => 'get-item']);
        $itemChange = $this->getItem(['id' => $params['id_change']], ['task' => 'get-item']);

        self::where('id', $itemCurrent->id)->update(['sort' => $itemChange->sort]);
        self::where('id', $itemChange->id)->update(['sort' => $itemCurrent->sort]);
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

