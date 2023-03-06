<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use NodeTrait;

    protected $fillable = ['name', 'link', 'type', 'category_id','tournament_categories_id','is_special_page', 'post_id', 'status', 'created_by', 'updated_by'];

    public function setCategoryIdAttribute($value)
    {
        if ($value === '0') {
            $this->attributes['category_id'] = null;
        } else {
            $this->attributes['category_id'] = $value;
        }
    }

    public function getNameWithDepthAttribute()
    {
        return str_repeat(' /----- ', $this->depth) . $this->name;
    }

    public function getAdminList()
    {
        return $this->withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();
    }

    public function getAllDefaultOrder()
    {
        return $this->withDepth()->defaultOrder();
    }

    public function storeItem($params)
    {
        $params['created_by'] = @session('userInfo')['id'];
        $params['updated_by'] = @session('userInfo')['id'];
        $parent = $this->find($params['parent_id']);
        $this->create($params, $parent);
    }

    public function updateItem($params)
    {
        $params['updated_by'] = @session('userInfo')['id'];
        $parent = $this->find($params['parent_id']);
        $node = $current = $this->find($params['id']);
        $node->update($params);
        if ($current->parent_id != $params['parent_id']) $node->appendToNode($parent)->save();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
