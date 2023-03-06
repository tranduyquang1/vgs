<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\old\ArticleRequest as MainRequest;
use App\Models\old\ArticleModel as MainModel;
use App\Models\old\CateNewsModel;

class ArticleController extends AdminController
{
    public function __construct()
    {
        $this->pathViewController = 'admin.pages.post.';
        $this->controllerName = 'post';
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 30;

        $categoryModel = new CateNewsModel();
        $categories = $categoryModel->createSelectCategory();
        $cateNews = [];
        foreach ($categories as $id => $category)
            $cateNews[$id] = preg_replace('/\|------/', '', $category, 1);
        view()->share('cateNews', $cateNews);

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

            return redirect()->route($this->controllerName)->with("zvn_notify", $notify);
        }
    }
}