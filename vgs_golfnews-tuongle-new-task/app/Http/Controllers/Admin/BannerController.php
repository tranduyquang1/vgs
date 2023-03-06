<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerSaveRequest;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BannerController extends Controller
{
    public $controllerName = 'banner';
    public $pathViewController = 'admin.pages.banner.';
    protected $model;
    protected $params = [];

    public function __construct(Banner $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        $this->params["pagination"]["totalItemsPerPage"] = 15;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        Gate::forUser($this->user)->authorize('index', $this->model);
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['filter']['page'] = $request->input('filter_page', 'default');
        $this->params['filter']['type'] = $request->input('filter_type', 'default');
        $this->params['filter']['position'] = $request->input('filter_position', 'default');
        $this->params['filter']['is_mobile'] = $request->input('filter_is_mobile', 'default');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');

        $items = $this->model->getAdminList($this->params);
        $itemsStatusCount = $this->model->getAdmincountItems($this->params);
        $params = $this->params;
        return view($this->pathViewController . 'index', compact('items', 'params', 'itemsStatusCount'));
    }

    public function form(Request $request)
    {
        Gate::forUser($this->user)->authorize('form', $this->model);
        $item = null;
        if ($request->id) {
            $item = $this->model->find($request->id);
        }
        return view($this->pathViewController . 'form', compact('item'));
    }

    public function save(BannerSaveRequest $request)
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

    public function delete(Request $request) {
        Gate::forUser($this->user)->authorize('delete', $this->model);
        $item = $this->model->find($request->id);
        $this->model->deleteThumb($item->thumb);
        $item->delete();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Xóa phần tử thành công!');
    }
}
