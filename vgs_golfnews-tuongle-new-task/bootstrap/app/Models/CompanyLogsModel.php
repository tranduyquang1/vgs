<?php

namespace App\Models;

use App\Models\Relations\CompanyLogRelationTrait;
use DB;

class CompanyLogsModel extends AdminModel
{
    use CompanyLogRelationTrait;

    public function __construct()
    {
        $this->table = 'company_logs';
        $this->folderUpload = '';
        $this->fieldSearchAccepted = ['id', 'name'];
        parent::__construct();
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select($this->table . '.*');

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

            $query->orderBy($this->table . '.sort', 'asc');

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

        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'add-item') {
            $params['created'] = date('Y-m-d H:i:s', time());

            self::insert($this->prepareParams($params));
        }

        if ($options['task'] == 'edit-item') {
            $params['modified'] = date('Y-m-d H:i:s', time());

            self::where(['id' => $params['id']])->update($this->prepareParams($params));
        }
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item') {
            $result = self::select()->where('id', $params['id'])->first();
        }
        return $result;
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item')
            self::where('id', $params['id'])->delete();
    }
}
