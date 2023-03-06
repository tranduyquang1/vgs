<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostSaveRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class SeagamesPostController extends Controller
{
    public $controllerName = 'post';
    public $pathViewController = 'admin.pages.post.';
    protected $model;
    protected $params = [];

    public function __construct(Post $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        $this->params["pagination"]["totalItemsPerPage"] = 15;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-index");
        $this->params['filter']['post_status'] = $request->input('filter_post_status', 'default');
        $this->params['filter']['category_id'] = $request->input('filter_category_id', 'default');
        $this->params['filter']['post_format'] = $request->input('filter_post_format', 'default');
        $this->params['filter']['post_is_on_slider'] = $request->input('filter_post_is_on_slider', 'default');
        $this->params['filter']['post_is_hot_news'] = $request->input('filter_post_is_hot_news', 'default');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');
        $this->params["select"]["field"] = $request->input('select_field', null);
        $this->params["select"]["value"] = $request->input('select_value', 'default');

        $items = $this->model->getAdminList($this->params);
        $params = $this->params;
        $categories = (new \App\Models\Category)->getAllForSelectBox();
        $userLevel = session('userInfo')->level;

        return view($this->pathViewController . 'index', compact('items', 'params', 'categories', 'userLevel'));
    }


    public function vietnameseForm(Request $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-form");
        $item = null;
        if ($request->id) {
            $item = $this->model->find($request->id);
        }
        $categories = (new \App\Models\Category)->getAllForSelectBox();
        $userLevel = session('userInfo')->level;
        return view($this->pathViewController . "$userLevel.seagamesVietnameseForm", compact('item', 'categories', 'userLevel'));
    }
    public function englishForm(Request $request, $id)
    {
        dd($id);
        Gate::forUser($this->user)->authorize("$this->controllerName-form");
        $item = null;
        if ($request->id) {
            $item = $this->model->find($request->id);
        }
        $categories = (new \App\Models\Category)->getAllForSelectBox();
        $userLevel = session('userInfo')->level;
        return view($this->pathViewController . "$userLevel.seagamesEnglishForm", compact('item', 'categories', 'userLevel'));
    }

    public function vietnameseSave(PostSaveRequest $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-save");
        if ($request->id) {
            $notify = "Cập nhật phần tử thành công!";
            $this->model->updateItem($request->all());
        } else {
            $notify = "Thêm phần tử thành công!";
            $this->model->storeItem($request->all());
        }
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", $notify);
    }
    public function englishSave(PostSaveRequest $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-save");
        if ($request->id) {
            $notify = "Cập nhật phần tử thành công!";
            $this->model->updateItem($request->all());
        } else {
            $notify = "Thêm phần tử thành công!";
            $this->model->storeItem($request->all());
        }

        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", $notify);
    }
    public function delete(Request $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-delete");
        $item = $this->model->find($request->id);
        $this->model->deleteThumb($item->thumbnail);
        $item->delete();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Xóa phần tử thành công!');
    }

    public function updateSlug()
    {
        try {
            Post::chunk(100, function ($posts) {
                foreach ($posts as $post) {
                    if ($post->status == 'published') {
                        $post->slug = Str::slug($post->title);
                        $post->save();
                    }
                }
            });
            return '123';
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
