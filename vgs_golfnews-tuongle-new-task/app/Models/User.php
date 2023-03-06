<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends \Illuminate\Foundation\Auth\User
{
    protected $fillable = ['email', 'password', 'status', 'level', 'name', 'created_by', 'updated_by'];
    protected $crudNotAccepted = ['_token', 'q'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function prepareParams($params)
    {
        return array_diff_key($params, array_flip($this->crudNotAccepted));
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

        if (isset($params['filter']['level']) && $params['filter']['level'] !== "default") {
            $query->where('level', $params['filter']['level']);
        }

        return $query->latest('id')->paginate($params['pagination']['totalItemsPerPage']);
    }

    public function getAdminCountItems($params)
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

        if (isset($params['filter']['level']) && $params['filter']['level'] !== "default") {
            $query->where('level', $params['filter']['level']);
        }

        return $query->get()->toArray();
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

    public function getAuthItem($params)
    {
        $item = $this->where('email', $params['email'])->first();

        if ($item && Hash::check($params['password'], @$item->password)) return $item;

        return null;
    }

    public function isSuperAdmin()
    {
        return $this->level == 'super_admin';
    }

    public function isAdmin()
    {
        return $this->level == 'admin';
    }

    public function isUser()
    {
        return $this->level == 'user';
    }

    public function isUserAds()
    {
        return $this->level == 'user_ads';
    }
    public function isUserTournament()
    {
        return $this->level == 'user_tournament';
    }
}
