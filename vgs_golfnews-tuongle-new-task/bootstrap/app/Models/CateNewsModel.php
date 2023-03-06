<?php

namespace App\Models;

use App\Models\Relations\CateNewsRelationTrait;
use DB;
use Kalnoy\Nestedset\NodeTrait;

class CateNewsModel extends AdminModel
{
    use NodeTrait;
    use CateNewsRelationTrait;

    public function __construct()
    {
        $this->table = 'cate_news';
        $this->fieldSearchAccepted = ['id', 'name'];

        parent::__construct();
    }

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
            $query->where($this->table . '.name', '<>', 'root')->orderBy($this->table . '._lft', 'asc');

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

            $result = $query->where('name', '<>', 'root')->get()->toArray();
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
            $params['created_by'] = $username;
            $params['created'] = date('Y-m-d H:i:s', time());
            $parent = self::find($params['parent_id']);

            self::create($this->prepareParams($params), $parent);
        }

        if ($options['task'] == 'edit-item') {
            $params['modified_by'] = $username;
            $params['modified'] = date('Y-m-d H:i:s', time());
            $parent = self::find($params['parent_id']);

            $query = $current = self::find($params['id']);
            $query->update($this->prepareParams($params));
            if ($current->parent_id != $params['parent_id'])
                $query->prependToNode($parent)->save();
        }
    }

    public function getItem($params = null, $options = null)
    {
        $result = null;

        if ($options['task'] == 'get-item')
            $result = self::select()->where('id', $params['id'])->first();

        if ($options['task'] == 'get-info') {
            $status = 'active';
            $result = self::select()
                ->where($this->table . '.id', '=', $params['id'])
                ->where($this->table . '.status', '=', $status)->first();
        }

        if ($options['task'] == 'get-child-by-parent') {
            $parent = self::select('id', 'name', '_lft', '_rgt')->where('id', '=', $params['id'])->first();
            if (!empty($parent)) {
                $query = $this->select('id', 'name')->where('_lft', '>', $parent->_lft)->where('_rgt', '<', $parent->_rgt);
                $result = $query->get()->toArray();
            } else
                $result = [];
        }

        return $result;
    }

    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item')
            self::where('id', $params['id'])->delete();
    }

    public function getTree()
    {
        return self::get()->toTree();
    }

    public function createSelectMenus()
    {
        $nodes = self::get()->toTree();
        $listMenus = [];
        $traverse = function ($categories, $prefix = '') use (&$traverse, &$listMenus) {
            foreach ($categories as $category) {
                $id = $category->id;
                $name = $prefix . ' ' . $category->name;
                $listMenus[$id] = $name;
                $traverse($category->children, $prefix . '|------');
            }
        };

        $traverse($nodes);
        return $listMenus;
    }

    public function createSelectCategory()
    {
        $nodes = self::get()->toTree();
        $listMenus = [];
        $traverse = function ($categories, $prefix = '') use (&$traverse, &$listMenus) {
            foreach ($categories as $category) {
                $id = $category->id;
                $name = $prefix . ' ' . $category->name;
                if ($category->name != 'root')
                    $listMenus[$id] = $name;

                $traverse($category->children, $prefix . '|------');
            }
        };

        $traverse($nodes);
        return $listMenus;
    }
}
