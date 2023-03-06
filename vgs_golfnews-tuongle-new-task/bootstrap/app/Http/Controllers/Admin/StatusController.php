<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StatusRequest as MainRequest;
use App\Models\old\StatusModel as MainModel;

class StatusController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController = 'admin.pages.status.';
        $this->controllerName = 'status';
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 10;

        parent::__construct();
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
}
