<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\old\EmailBccRequest as MainRequest;
use App\Models\old\EmailBccModel as MainModel;
use Exception;
use Illuminate\Http\Request;

class EmailBccController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController = 'admin.pages.email_bcc.';
        $this->controllerName = 'emailBcc';
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 50;
        parent::__construct();
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();

            $task = "add-item";
            $notify = "Thêm phần tử thành công!";

            if ($params['id'] !== null) {
                $task = "edit-item";
                $notify = "Cập nhật phần tử thành công!";
            }
            $this->model->saveItem($params, ['task' => $task]);

            return redirect()->route('settings/form', ['key_value' => 'setting-email'])->with("zvn_notify", $notify);
        }
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

    public function attribute(Request $request)
    {
        try {
            $params = [
                'id' => $request->id,
                $request->field => is_array($request->value) ? json_encode($request->value) : $request->value
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

    public function bccContact(Request $request)
    {
        try {
            $params["contact"] = $request->status == 'active' ? 'inactive' : 'active';
            $params["id"] = $request->id;
            $this->model->saveItem($params, ['task' => 'edit-item']);

            return response()->json([
                'status' => true,
                'response' => $params["contact"],
                'link' => route($this->controllerName . '/bccContact', ['status' => $params["contact"], 'id' => $params["id"]])
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);

        }
    }

    public function bccOrder(Request $request)
    {
        try {
            $params["order"] = $request->status == 'active' ? 'inactive' : 'active';
            $params["id"] = $request->id;
            $this->model->saveItem($params, ['task' => 'edit-item']);

            return response()->json([
                'status' => true,
                'response' => $params["order"],
                'link' => route($this->controllerName . '/bccOrder', ['status' => $params["order"], 'id' => $params["id"]])
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);

        }
    }

    public function delete(Request $request)
    {
        $params["id"] = $request->id;
        $this->model->deleteItem($params, ['task' => 'delete-item']);

        return redirect()->route('settings/form', ['key_value' => 'setting-email'])->with("zvn_notify", 'Xóa phần tử thành công!');
    }
}