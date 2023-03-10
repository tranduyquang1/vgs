<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $pathViewController;
    protected $controllerName;
    protected $params = [];
    protected $model;

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');
        $this->params["select"]["field"] = $request->input('select_field');
        $this->params["select"]["value"] = $request->input('select_value', 'default');

        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items']);

        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount
        ]);
    }

    public function form(Request $request)
    {
        $item = null;
        if ($request->id !== null) {
            $params["id"] = $request->id;
            $item = $this->model->getItem($params, ['task' => 'get-item']);
        }

        return view($this->pathViewController . 'form', [
            'item' => $item
        ]);
    }

    public function status(Request $request)
    {
        try {
            $params["currentStatus"] = $request->status;
            $params["id"] = $request->id;
            $this->model->saveItem($params, ['task' => 'change-status']);
            $response = ($params["currentStatus"] == 'active') ? 'inactive' : 'active';
            return response()->json([
                'status' => true,
                'response' => $response,
                'link' => route($this->controllerName . '/status', ['status' => $response, 'id' => $params["id"]])
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request)
    {
        if ($request->method() == 'POST') {
            $msg = null;
            $params = $request->all();
            if ($params['type'] == 'ordering') {
                if (!empty($params['cid'])) {
                    foreach ($params['cid'] as $id => $value)
                        $this->model->saveItem([
                            'sort' => $params['ordering'][$id]
                            , 'id' => $id
                        ], ['task' => 'edit-item']);

                    $msg = 'C???p nh???t s???p x???p th??nh c??ng!';
                }
            }

            return redirect()->route($this->controllerName)->with("zvn_notify", $msg);
        }
    }

    public function attribute(Request $request)
    {
        try {
            $params = [
                'id' => $request->id,
                $request->field => $request->value
            ];
            $this->model->saveItem($params, ['task' => 'edit-item']);

            return response()->json([
                'status' => true,
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);

        }
    }

    public function config(Request $request)
    {
        try {
            $params["config"] = $request->config;
            $params["currentConfig"] = $request->value;
            $params["id"] = $request->id;

            $this->model->saveItem($params, ['task' => 'change-config']);
            $response = ($params["currentConfig"] == 1) ? 0 : 1;

            return response()->json([
                'status' => true,
                'response' => $response,
                'link' => route($this->controllerName . '/config', [
                    'config' => $params['config'],
                    'value' => $response,
                    'id' => $params["id"]
                ])
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function isHome(Request $request)
    {
        try {
            $params["current"] = $request->isHome;
            $params["id"] = $request->id;
            $this->model->saveItem($params, ['task' => 'change-isHome']);
            $response = ($params["current"] == 'yes') ? 'no' : 'yes';

            return response()->json([
                'status' => true,
                'response' => $response,
                'link' => route($this->controllerName . '/isHome', ['isHome' => $response, 'id' => $params["id"]])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function ordering(Request $request)
    {
        $params["id_current"] = $request->id_current;
        $params["id_change"] = $request->id_change;
        $this->model->ordering($params);

        return back()->with("zvn_notify", "S???p x???p ph???n t??? th??nh c??ng!");
    }

    public function delete(Request $request)
    {
        $params["id"] = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);

        return back()->with('zvn_notify', 'X??a ph???n t??? th??nh c??ng!');
    }
}