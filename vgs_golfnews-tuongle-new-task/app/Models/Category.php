<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;

//    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $fillable = ['name', 'id_old', 'homepage_position', 'created_by', 'updated_by'];
    protected $appends = ['my_posts_3', 'my_posts_4', 'my_posts_5', 'my_posts_6'];

    public function getAdminList()
    {
        return $this->withDepth()->having('depth', '>', 0)->defaultOrder()->get()->toTree();
    }

    public function getAllDefaultOrder()
    {
        return $this->withDepth()->defaultOrder();
    }

    public function getNameWithDepthAttribute()
    {
        return str_repeat(' /----- ', $this->depth) . $this->name;
    }

    public function getAllForSelectBox()
    {
        return $this->getAllDefaultOrder()->having('depth', '>', 0)->get()->toFlatTree()->pluck('name_with_depth', 'id')->toArray();
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

    public function frontendCategoriesHomepage()
    {
        return $this->whereNotNull('homepage_position')->defaultOrder();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postsFrontendArticle()
    {
//        dd($this->getAttribute('id'));
        return $this->posts()->select('id', 'title', 'thumbnail', 'excerpt', 'youtube_url', 'is_old', 'category_id', 'is_hot_style_life')->latest('published_at_display')->published()->where('format', '<>', 'video');
    }

    public function postsHome()
    {
        return $this->posts()->latest('published_at_display')->published()->where('format', 'article');
    }

    public function postsFrontend()
    {
        return $this->posts()->latest('published_at_display')->published();
    }

    public function postsFrontendVideo()
    {
        return $this->posts()->video()->latest('published_at_display')->published();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // ACCESSOR
    public function getMyPosts3Attribute()
    {
        $id = $this->id;
        return Cache::remember("model.category.posts.$id", 120, function () use ($id) {
            $categories = Category::descendantsAndSelf($id)->pluck('id');
            return Post::with('category')->where('language', 0)->whereIn('category_id', $categories)->latestPublished()->take(3)->get();
        });
    }

    public function getMyPosts4Attribute()
    {
        $id = $this->id;
        return Cache::remember("model.category.posts.$id", 120, function () use ($id) {
            $categories = Category::descendantsAndSelf($id)->pluck('id');
            return Post::with('category')->where('language', 0)->whereIn('category_id', $categories)->latestPublished()->take(4)->get();
        });
    }

    public function getMyPosts5Attribute()
    {
        $id = $this->id;
        return Cache::remember("model.category.posts.$id", 120, function () use ($id) {
            $categories = Category::descendantsAndSelf($id)->pluck('id');
            return Post::with('category')->where('language', 0)->whereIn('category_id', $categories)->latestPublished()->take(5)->get();
        });
    }

    public function getMyPosts6Attribute()
    {
        $id = $this->id;
        return Cache::remember("model.category.posts.$id", 120, function () use ($id) {
            $categories = Category::descendantsAndSelf($id)->pluck('id');
            return Post::with('category')->where('language', 0)->whereIn('category_id', $categories)->latestPublished()->take(6)->get();
        });
    }
}
