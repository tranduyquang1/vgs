<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerSaveRequest;
use App\Models\BannersCategories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;



class BannerCategoriesController extends Controller
{
    public $controllerName = 'banner-categories';
    public $pathViewController = 'admin.pages.banner-categories.';
    protected $model;
    protected $params = [];

    public function __construct(BannersCategories $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        $this->params["pagination"]["totalItemsPerPage"] = 15;
        view()->share('controllerName', $this->controllerName);
    }

    public function ListCategoriesIndex(Request $request){
        Gate::forUser($this->user)->authorize("banners-categories-index", $this->model);
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['filter']['category_id'] = $request->input('filter_category_id', 'default');
        $this->params['filter']['type'] = $request->input('filter_type', 'default');
        $this->params['filter']['position'] = $request->input('filter_position', 'default');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');

        $items = $this->model->getAdminList($this->params);
        $itemsStatusCount = $this->model->getAdmincountItems($this->params);
        $params = $this->params;
        return view($this->pathViewController . 'index', compact('items', 'params', 'itemsStatusCount'));
    }
    public function ListCategoriesForm(Request $request)
    {
        Gate::forUser($this->user)->authorize('banners-categories-form', $this->model);
        $item = null;
        if ($request->id) {
            $item = $this->model->find($request->id);
        }
        return view($this->pathViewController . 'form', compact('item'));
    }
    public function ListCategoriesSave(BannerSaveRequest $request)
    {   
        Gate::forUser($this->user)->authorize('banners-categories-save', $this->model);
        if ($request->id) {
            $notify = "Cập nhật phần tử thành công!";
            $this->model->updateItem($request->all());
        } else {
            $notify = "Thêm phần tử thành công!";
            $this->model->storeItem($request->all());
        }

        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", $notify);
    }

    public function ListCategoriesDelete(Request $request) {
        Gate::forUser($this->user)->authorize('banners-categories-delete', $this->model);
        $item = $this->model->find($request->id);
        $this->model->deleteThumb($item->thumb);
        $item->delete();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Xóa phần tử thành công!');
    }
 
}
