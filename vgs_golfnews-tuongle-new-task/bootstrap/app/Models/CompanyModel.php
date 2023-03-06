<?php

namespace App\Models;

use App\Models\Relations\CompanyRelationTrait;
use Carbon\Carbon;
use DB;

class CompanyModel extends AdminModel
{
    use CompanyRelationTrait;

    public function __construct()
    {
        $this->table = 'company';
        $this->folderUpload = '';
        $this->fieldSearchAccepted = ['id'];
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
        $username = session('userInfo')['username'];

        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if ($options['task'] == 'add-item') {
            if(isset($params['ngay_xuat_hang']) && !empty($params['ngay_xuat_hang']))
                $params['ngay_xuat_hang'] = Carbon::parse($params['ngay_xuat_hang'])->format('Y-m-d');

            $params['created_by'] = $username;
            $params['created'] = $params['time'] ?? date('Y-m-d H:i:s', time());
            unset($params['time']);
        
            return self::insertGetId($this->prepareParams($params));
        }

        if ($options['task'] == 'edit-item') {
            if(isset($params['ngay_xuat_hang']) && !empty($params['ngay_xuat_hang']))
                $params['ngay_xuat_hang'] = Carbon::parse($params['ngay_xuat_hang'])->format('Y-m-d');

            $params['modified_by'] = $username;
            $params['modified'] = $params['time'] ?? date('Y-m-d H:i:s', time());;
            unset($params['time']);
            $dataOld = $this->where('id', $params['id'])->first()->toArray();
            self::where(['id' => $params['id']])->update($this->prepareParams($params));

            $dataNew = $this->where('id', $params['id'])->first()->toArray();

            $logModel = new CompanyLogsModel();
            $logModel->saveItem([
                'company_id' => $params['id'],
                'user_id' => session('userInfo')['id'],
                'data_old' => json_encode($dataOld),
                'data_new' => json_encode($dataNew)
            ], ['task' => 'add-item']);

            return $params['id'];
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

    public function getIdSearchFilter($params) {
        $query = $this->select('id');
        $query->where('sheets_id', $params['sheet_id']);
        foreach($params['search'] as $field => $value) {
            if(!empty($value)) {
                if($field === 'ngay_xuat_hang') {
                    $query->whereDate($field, '=', Carbon::parse($value));
                }
                else
                    $query->where($field, 'LIKE', '%'.$value.'%');
            }
        }
        return $query->get()->toArray();
    }

    public function getBy($params) {
        $query = $this->select();
        unset($params['page']);
        foreach($params as $field => $value) {
            if(!empty($value)) {
                if($field === 'ngay_xuat_hang') {
                    $query->whereDate($field, '=', Carbon::parse($value));
                }
                else
                    $query->where($field, 'LIKE', '%'.$value.'%');
            }
        }
        return $query->paginate(30);
    }

    public function getAll($params) {
        $query = $this->select();
        unset($params['page']);
        foreach($params as $field => $value) {
            if(!empty($value)) {
                if($field === 'ngay_xuat_hang') {
                    $query->whereDate($field, '=', Carbon::parse($value));
                }
                else
                    $query->where($field, 'LIKE', '%'.$value.'%');
            }
        }
        return $query->get()->toArray();
    }
}
