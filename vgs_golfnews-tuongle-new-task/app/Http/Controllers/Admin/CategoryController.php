<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public $controllerName = 'category';
    public $pathViewController = 'admin.pages.category.';
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        view()->share('controllerName', $this->controllerName);
    }

    public function index()
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-index");
        $items = $this->model->getAdminList();
        return view($this->pathViewController . 'index', compact('items'));
    }

    public function form(Request $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-form");
        $item = null;
        $categories = $this->model->getAllDefaultOrder();
        if ($request->id) {
            $item = $this->model->find($request->id);
            $categories = $categories->where('_lft', '<', $item->_lft)->orWhere('_lft', '>', $item->_rgt);
        }
        $categories = $categories->get()->toFlatTree()->pluck('name_with_depth', 'id');
        return view($this->pathViewController . 'form', compact('item', 'categories'));
    }

    public function save(Request $request)
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

    public function updateTree(Request $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-update-tree");
        $data = $request->data;
        $root = $this->model->find(1);
        $this->model->rebuildSubtree($root, $data);
    }

    public function delete(Request $request) {
        Gate::forUser($this->user)->authorize("$this->controllerName-delete");
        $this->model->find($request->id)->delete();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Xóa phần tử thành công!');
    }

    public function fixTree() {
        Category::fixTree();
    }
}
