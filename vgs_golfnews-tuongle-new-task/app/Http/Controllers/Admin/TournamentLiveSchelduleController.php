<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TournamentLiveSchelduleSaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\TournamentLiveScheldule;


class TournamentLiveSchelduleController extends Controller
{
    public $controllerName = 'tournament-live-scheldule';
    public $pathViewController = 'admin.pages.tournament-live-scheldule.';
    protected $model;
    protected $params = [];

    public function __construct(TournamentLiveScheldule $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        $this->params["pagination"]["totalItemsPerPage"] = 15;
        view()->share('controllerName', $this->controllerName);
    }

    public function schelduleIndex(Request $request){
        Gate::forUser($this->user)->authorize("tournament-live-scheldule-index", $this->model);
        $this->params['filter']['tournament_categories_id'] = $request->input('filter_tournament_categories_id', 'default');
        $this->params['filter']['type'] = $request->input('filter_type', 'default');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');

        $items = $this->model->getAdminList($this->params);
        $params = $this->params;
        return view($this->pathViewController . 'index', compact('items', 'params'));
    }
    public function schelduleForm(Request $request)
    {
        Gate::forUser($this->user)->authorize('tournament-live-scheldule-form', $this->model);
        $item = null;
        if ($request->id) {
            $item = $this->model->find($request->id);
        }
        return view($this->pathViewController . 'form', compact('item'));
    }
    public function schelduleSave(TournamentLiveSchelduleSaveRequest $request)
    {   
        
        Gate::forUser($this->user)->authorize('tournament-live-scheldule-save', $this->model);
        if ($request->id) {
            $notify = "Cập nhật phần tử thành công!";
            $this->model->updateItem($request->all());
        } else {
            $notify = "Thêm phần tử thành công!";
            $this->model->storeItem($request->all());
        }

        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", $notify);
    }

    public function schelduleDelete(Request $request) {
        Gate::forUser($this->user)->authorize('tournament-live-scheldule-delete', $this->model);
        $item = $this->model->find($request->id);
        $this->model->deleteThumb($item->thumb);
        $item->delete();
        return redirect()->route("admin.$this->controllerName.index")->with("zvn_notify", 'Xóa phần tử thành công!');
    }

 
}
