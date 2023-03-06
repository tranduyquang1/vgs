<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\old\CateNewsRequest as MainRequest;
use App\Models\old\CateNewsModel as MainModel;
use Illuminate\Http\Request;

class CateNewsController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController = 'admin.pages.cate_news.';
        $this->controllerName = 'cateNews';
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 30;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params["search"]["field"] = $request->input('search_field', null);
        $this->params["search"]["value"] = $request->input('search_value', null);
        $this->params["select"]["field"] = $request->input('select_field', null);
        $this->params["select"]["value"] = $request->input('select_value', 'default');

        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $listTree = $this->model->createSelectMenus();
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items']);

        foreach ($items as &$val) {
            var_dump(@$listTree[$val['id']]);
            $id = $val['id'];
            $val['nameByLv'] = preg_replace('/\|------/', '', $listTree[$id], 1);
        }

        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount,
        ]);
    }

    public function form(Request $request)
    {
        $item = null;
        $itemContents = null;
        if ($request->id !== null) {
            $params["id"] = $request->id;
            $item = $this->model->getItem($params, ['task' => 'get-item']);
        }
        $listMenus = $this->model->createSelectMenus();

        return view($this->pathViewController . 'form', [
            'item' => $item,
            'listMenus' => $listMenus,
        ]);
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();
            $task = "add-item";
            $msg = "Thêm phần tử thành công!";
            if ($params['id'] !== null) {
                $task = "edit-item";
                $msg = "Cập nhật phần tử thành công!";
            }
            $this->model->saveItem($params, ['task' => $task]);
            return redirect()->route($this->controllerName)->with("zvn_notify", $msg);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $node = $this->model::find($id);
        $node->delete();
        return redirect()->route($this->controllerName)->with("zvn_notify", "Xóa phần tử thành công!");
    }

    public function ordering(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $node = $this->model::find($id);

        if ($type == 'up') {
            $node->up();
        } else {
            $node->down();
        }

        return redirect()->route($this->controllerName)->with("zvn_notify", "Thay đổi phần tử thành công!");
    }
}
