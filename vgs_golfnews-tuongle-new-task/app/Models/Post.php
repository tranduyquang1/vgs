<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Support\Str;


class Post extends AdminModel implements Viewable
{
    use InteractsWithViews;

    protected $searchAccepted = ['title', 'excerpt'];
//    protected $fillable = ['title', 'url', 'page', 'position', 'status', 'thumb'];
    protected $guarded = ['_token', 'thumb_current', 'thumb_large_current', 'thumb_small_current', 'user_level', 'q', 'audio_current'];
    protected $crudNotAccepted = ['_token', 'thumb_current', 'thumb_large_current', 'thumb_small_current', 'user_level', 'q', 'audio_current'];
    protected $folderUpload = 'post';
    protected $casts = [
        'published_at_display' => 'datetime:Y-m-d\TH:i:s',
    ];

    public function getAdminList($params)
    {
        $query = $this->with('category');

        $query->where('status', '<>', 'draft')->where('status', '<>', 'deleted')->where('status', '<>', 'pendingsecretary');

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

        if (isset($params['filter']['post_status']) && $params['filter']['post_status'] !== "default") {
            $query->where('status', $params['filter']['post_status']);
        }

        if (isset($params['filter']['category_id']) && $params['filter']['category_id'] !== "default") {
            $categories = Category::descendantsAndSelf($params['filter']['category_id'])->pluck('id');
            $query->whereIn('category_id', $categories);
        }

        if (isset($params['filter']['post_format']) && $params['filter']['post_format'] !== "default") {
            $query->where('format', $params['filter']['post_format']);
        }

        if (isset($params['filter']['post_is_on_slider']) && $params['filter']['post_is_on_slider'] !== "default") {
            $query->where('is_on_slider', $params['filter']['post_is_on_slider']);
        }

        if (isset($params['filter']['post_is_hot_news']) && $params['filter']['post_is_hot_news'] !== "default") {
            $query->where('is_hot_news', $params['filter']['post_is_hot_news']);
        }

        return $query->latest('published_at_display')->paginate($params['pagination']['totalItemsPerPage']);
    }

    public function getAdmincountItems($params)
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

        return $query->get()->toArray();
    }

    public function storeItem($params)
    {
        $params['is_old'] = 0;
        if (@$params['thumbnail']) $params['thumbnail'] = $this->uploadThumb($params['thumbnail'], 720);
        if (@$params['thumbnail_large']) $params['thumbnail_large'] = $this->uploadThumb($params['thumbnail_large'], 1920);
        if (@$params['thumbnail_small']) $params['thumbnail_small'] = $this->uploadThumb($params['thumbnail_small'], 100);
        if (@$params['audio']) $params['audio'] = $this->uploadMedia($params['audio']);
        $params['created_by'] = @session('userInfo')['id'];
        $params['updated_by'] = @session('userInfo')['id'];
        $params['slug'] = Str::slug($params['title']);
        $this->create($params);
    }

    public function updateItem($params)
    {
        if (@$params['thumbnail']) {
            $params['thumbnail'] = $this->uploadThumb($params['thumbnail'], 720);
            $this->deleteThumb($params['thumb_current']);
        }

        if (@$params['thumbnail_large']) {
            $params['thumbnail_large'] = $this->uploadThumb($params['thumbnail_large'], 1920);
            $this->deleteThumb($params['thumb_large_current']);
        }

        if (@$params['thumbnail_small']) {
            $params['thumbnail_small'] = $this->uploadThumb($params['thumbnail_small'], 100);
            $this->deleteThumb($params['thumb_small_current']);
        }

        if (@$params['audio']) {
            $this->uploadMedia($params['audio']);
            $this->deleteThumb($params['audio_current']);
        }

        $params['slug'] = Str::slug($params['title']);
        $params['updated_by'] = @session('userInfo')['id'];
        $this->where('id', $params['id'])->update($this->prepareParams($params));
    }

    // Frontend
    public function frontendHomepageSlider()
    {
        return $this->select('id', 'title', 'excerpt', 'thumbnail', 'youtube_url', 'is_old')->latest('published_at_display')->published()->onSlider()->take(3)->get();
    }

    public function frontendHomepageHotNews()
    {
        return $this->select('id', 'title', 'thumbnail', 'youtube_url', 'is_old')->latest('published_at_display')->published()->hotNews()->take(3)->get();
    }

    public function frontendHomepageVideo()
    {
        return $this->select('id', 'thumbnail', 'youtube_url', 'is_old')->latest('published_at_display')->published()->video()->take(3)->get();
    }

    public function updateSlug()
    {
        Post::query()->update(['slug' => Str::slug($this->title)]);
    }

    // Relation
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('published_at_display', '<=', now());
    }

    public function scopeOnSlider($query)
    {
        return $query->where('is_on_slider', 1);
    }

    public function scopeHotNews($query)
    {
        return $query->where('is_hot_news', 1);
    }

    public function scopeVideo($query)
    {
        return $query->where('format', 'video');
    }

    public function scopeNotVideo($query)
    {
        return $query->where('format', '<>', 'video');
    }

    public function scopePostArticle($query)
    {
        return $query->where('format', 'article');
    }

    public function scopeAdsNews($query)
    {
        return $query->where('is_ads_news', 1);
    }

    public function scopeNotSlider($query)
    {
        return $query->where('is_on_slider', 0);
    }

    public function scopeNotHotNews($query)
    {
        return $query->where('is_hot_news', 0);
    }

    public function scopeMostRead($query)
    {
        return $query->where('is_most_read', 1);
    }

    public function scopeLatestPublished($query)
    {
        return $query->where('status', 'published')->where('published_at_display', '<=', now())->latest('published_at_display');
    }

    // Accessor
    public function getYoutubeIdAttribute($value)
    {
        if (empty($this->youtube_url)) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->content, $match);
        } else {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->youtube_url, $match);
        }
        return @$match[1];
    }

    // Relation
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
