<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingController extends Controller
{
    public $controllerName = 'setting';
    public $pathViewController = 'admin.pages.setting.';
    protected $model;
    protected $params = [];

    public function __construct(Setting $model)
    {
        $this->model = $model;
        $this->user = User::find(@session('userInfo')['id']);
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        Gate::forUser($this->user)->authorize('setting');

        $keyValue = $request->input('key_value', 'setting-main');
        $item = $this->model->where('key_value', $keyValue)->firstOrFail();

//        if ($keyValue == 'setting-social') {
//            $values = $item->value;
//            foreach ($values as $key => $value) {
//                if (!empty($value)) {
//                    $values[$key] = implode(',', $value);
//                }
//            }
//            $item->value = $values;
//        }

//        $emailBccModel = new EmailBccModel();
//        $emailBcc = $emailBccModel->listItems($this->params, ['task' => 'admin-list-items']);
//
//        $emailTemplateModel = new EmailTemplateModel();
//        $emailTemplate = $emailTemplateModel->listItems($this->params, ['task' => 'admin-list-items']);

//        $arrEmailTemplate = [];
//        foreach ($emailTemplate as $template)
//            $arrEmailTemplate[$template->id] = $template->name;

//        'emailBcc' => $emailBcc,
//        'emailTemplate' => $emailTemplate,
//        'arrEmailTemplate' => $arrEmailTemplate

        return view($this->pathViewController . 'form', compact('item', 'keyValue'));
    }

    public function save(Request $request)
    {
        $this->model->saveItem($request->all());
        return redirect()->route("admin.$this->controllerName.index", ['key_value' => $request->key_value])->with("zvn_notify", 'Cập nhật thành công!');
    }
}
