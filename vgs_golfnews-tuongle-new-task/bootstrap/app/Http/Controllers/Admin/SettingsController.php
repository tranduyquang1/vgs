<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\old\SettingsRequest as MainRequest;
use App\Models\old\EmailBccModel;
use App\Models\old\EmailTemplateModel;
use App\Models\Setting as MainModel;
use Illuminate\Http\Request;

class SettingsController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController = 'admin.pages.settings.';
        $this->controllerName = 'settings';
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 30;
        parent::__construct();
    }

    public function form(Request $request)
    {
        $key_value = $request->key_value;
        $items = $this->model->getItem(null, ['task' => 'get-all']);

        $emailBccModel = new EmailBccModel();
        $emailBcc = $emailBccModel->listItems($this->params, ['task' => 'admin-list-items']);

        $emailTemplateModel = new EmailTemplateModel();
        $emailTemplate = $emailTemplateModel->listItems($this->params, ['task' => 'admin-list-items']);

        $arrEmailTemplate = [];
        foreach ($emailTemplate as $template)
            $arrEmailTemplate[$template->id] = $template->name;

        return view($this->pathViewController . 'form', [
            'items' => $items,
            'key_value' => $key_value,
            'emailBcc' => $emailBcc,
            'emailTemplate' => $emailTemplate,
            'arrEmailTemplate' => $arrEmailTemplate
        ]);
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();
            $key_value = $params['key_value'];
            $task = "add-item";
            $msg = "Thêm phần tử thành công!";
            $check = $this->model::where('key_value', $key_value)->exists();
            if ($check) {
                $task = "edit-item";
                $msg = "Cập nhật phần tử thành công!";
            }
            $this->model->saveItem($params, ['task' => $task]);
            return redirect()->route($this->controllerName . '/form', ['key_value' => $key_value])->with("zvn_notify", $msg);
        }
    }
}
