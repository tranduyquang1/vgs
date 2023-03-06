<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserSaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public $controllerName = 'user';
    public $pathViewController = 'admin.pages.user.';
    protected $model;
    protected $params = [];

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        $this->params["pagination"]["totalItemsPerPage"] = 15;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-index");
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['filter']['level'] = $request->input('filter_level', 'default');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');

        $items = $this->model->getAdminList($this->params);
        $itemsStatusCount = $this->model->getAdminCountItems($this->params);
        $params = $this->params;

        return view($this->pathViewController . 'index', compact('items', 'params', 'itemsStatusCount'));
    }

    public function form(Request $request)
    {
        Gate::forUser($this->user)->authorize("$this->controllerName-form");
        $item = null;
        if ($request->id) {
            $item = $this->model->find($request->id);
        }
        return view($this->pathViewController . 'form', compact('item'));
    }

    public function save(UserSaveRequest $request)
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

    public function changePassword(UserChangePasswordRequest $request) {
        Gate::forUser($this->user)->authorize("$this->controllerName-change-password");
        $this->model->where('id', $request->id)->update(['password' => bcrypt($request->password)]);
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Cập nhật thành công');
    }

    public function delete(Request $request) {
        Gate::forUser($this->user)->authorize("$this->controllerName-delete", $request->id);
        $this->model->find($request->id)->delete();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Xóa phần tử thành công!');
    }
}
