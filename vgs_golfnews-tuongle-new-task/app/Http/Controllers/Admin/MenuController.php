<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuSaveRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    public $controllerName = 'menu';
    public $pathViewController = 'admin.pages.menu.';
    protected $model;

    public function __construct(Menu $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        view()->share('controllerName', $this->controllerName);
    }

    public function index()
    {
        Gate::forUser($this->user)->authorize('index', $this->model);
        $items = $this->model->getAdminList();
        return view($this->pathViewController . 'index', compact('items'));
    }

    public function form(Request $request)
    {
        Gate::forUser($this->user)->authorize('form', $this->model);
        $item = null;
        $parents = $this->model->getAllDefaultOrder();
        if ($request->id) {
            $item = $this->model->find($request->id);
            $parents = $parents->where('_lft', '<', $item->_lft)->orWhere('_lft', '>', $item->_rgt);
        }
        $parents = $parents->get()->toFlatTree()->pluck('name_with_depth', 'id');
        $categories = (new \App\Models\Category)->getAllForSelectBox();
        return view($this->pathViewController . 'form', compact('item', 'parents', 'categories'));
    }

    public function save(MenuSaveRequest $request)
    {
        Gate::forUser($this->user)->authorize('save', $this->model);
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
        Gate::forUser($this->user)->authorize('updateTree', $this->model);
        $data = $request->data;
        $root = $this->model->find(1);
        $this->model->rebuildSubtree($root, $data);
    }

    public function delete(Request $request) {
        Gate::forUser($this->user)->authorize('delete', $this->model);
        $this->model->find($request->id)->delete();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Xóa phần tử thành công!');
    }
}
