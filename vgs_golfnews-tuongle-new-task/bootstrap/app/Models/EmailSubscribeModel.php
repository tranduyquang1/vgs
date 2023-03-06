<?php

namespace App\Models;

use DB;

class EmailSubscribeModel extends AdminModel
{
    protected $table = 'email_subscribe';
    protected $folderUpload = '';
    protected $fieldSearchAccepted = [
        'id',
        'phone'
    ];



    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select();

            if (isset($params['filter']['status']) && $params['filter']['status'] !== "all") {
                $query->where($this->table . '.status', '=', $params['filter']['status']);
            }

            if (isset($params['search']['value']) && $params['search']['value'] !== "") {

                if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($this->table . '.' . $params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                } else if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($this->table . '.' . $column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                }
            }

            if (isset($params['select']['field']) && $params['select']['value'] !== "default") {
                $query->where($this->table . '.' . $params['select']['field'], '=', "{$params['select']['value']}");
            }
            $query->orderBy('id', 'desc');
            $result = $query->paginate($params["pagination"]["totalItemsPerPage"]);
        }

        return $result;
    }

    public function countItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'admin-count-items') {
            $query = $this::groupBy('status')
                ->select(DB::raw('status , COUNT(id) as count'));

            if (isset($params['search']['value']) && $params['search']['value'] !== "") {
                if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                } else if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                }
            }

            if (isset($params['select']['field']) && $params['select']['value'] !== "default") {
                $query->where($params['select']['field'], '=', "{$params['select']['value']}");
            }

            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'count-agencies') {
            $query = $this::groupBy('district')
                ->select(DB::raw('district , COUNT(id) as count'));

            $result = $query->get()->toArray();
        }

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') {

            $params['status'] = "inactive";
            $params['created'] = date('Y-m-d H:i:s', time());
            if (!empty($params['email']))
                self::insert($this->prepareParams($params));
        }

        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-all')
            $result = self::select()->where('id', $params['id'])->get();


        if ($options['task'] == 'get-item')
            $result = self::select()->where('id', $params['id'])->first();


        if ($options['task'] == 'get-info') {
            $status = 'active';
            $result = self::select($this->table . '.id', $this->table . '.email', $this->table . '.status')
                ->where($this->table . '.id', '=', $params['id'])
                ->where($this->table . '.status', '=', $status)->first();;
        }

        return $result;
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item')
            self::where('id', $params['id'])->delete();
    }
}
