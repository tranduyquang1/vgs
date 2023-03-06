<?php

namespace App\Models;

use DB;
use Illuminate\Support\Facades\Storage;

class SettingsModel extends AdminModel
{
    public function __construct()
    {
        $this->table = 'settings';
        $this->folderUpload = '';
        $this->fieldSearchAccepted = ['id', 'question', 'answer'];

        parent::__construct();
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'admin-list-items') {
            $query = $this->select($this->table . '.id', $this->table . '.question', $this->table . '.answer',
                $this->table . '.status', $this->table . '.created',
                $this->table . '.created_by', $this->table . '.modified', $this->table . '.modified_by');
            if (isset($params['filter_status']) && $params['filter_status'] !== "all") {
                $query->where($this->table . '.status', '=', $params['filter_status']);
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

            $result = $query->paginate($params["pagination"]["totalItemsPerPage"]);
        }

        if ($options['task'] == 'latest-list-items') {
            $status = 'active';
            $query = $this->select($this->table . '.id', $this->table . '.name', $this->table . '.description',
                $this->table . '.status', $this->table . '.image')
                ->where($this->table . '.status', '=', $status)
                ->where($this->table . '.created', '<=', date('Y-m-d'))
                ->orderBy($this->table . '.created', 'desc')
                ->take(4);
            $result = $query->get()->toArray();
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
        if ($options['task'] == 'edit-item') {
            $data['value'] = json_encode($params);

            if ($params['key_value'] == 'setting-main')
                file_put_contents(public_path('cache/setting-main.json'), $data['value']);

            if ($params['key_value'] == 'setting-social')
                file_put_contents(public_path('cache/setting-social.json'), $data['value']);

            if ($params['key_value'] == 'setting-script')
                file_put_contents(public_path('cache/setting-script.json'), $data['value']);

            if ($params['key_value'] == 'setting-chat') {
                $data['value'] = json_encode([
                    'hotline' => json_encode($params['hotline']),
                    'facebook' => json_encode($params['facebook']),
                    'zalo' => json_encode($params['zalo']),
                    'service' => json_encode($params['service'])
                ]);
                file_put_contents(public_path('cache/setting-chat.json'), $data['value']);
            }

            if ($params['key_value'] == 'setting-seo')
                file_put_contents(public_path('cache/setting-seo.json'), $data['value']);

            $data['modified_by'] = $username;
            $data['modified'] = date('Y-m-d H:i:s', time());
            self::where(['key_value' => $params['key_value']])->update($this->prepareParams($data));
        }
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-all') {
            $result = self::select('id', 'key_value', 'value', 'status')->get()->toArray();
        }

        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'key_value', 'value', 'status')->where('key_value', $params['key'])->first();
        }

        if ($options['task'] == 'get-image') {
            $result = self::select('id', 'image')->where('id', $params['id'])->first();
        }

        if ($options['task'] == 'get-info') {
            $status = 'active';
            $result = self::select($this->table . '.id', $this->table . '.question', $this->table . '.answer',
                $this->table . '.status')
                ->where($this->table . '.id', '=', $params['id'])
                ->where($this->table . '.status', '=', $status)->first();;
        }

        return $result;
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {

            $item = self::getItem($params, ['task' => 'get-image']);
            if (Storage::exists($this->folderUpload . '/' . $item['image'])) {
                Storage::delete($this->folderUpload . '/' . $item['image']);
            }

            self::where('id', $params['id'])->delete();
        }
    }
}
