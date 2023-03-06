<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Foundation\Http\FormRequest;
class MenuSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $types = implode(',', array_keys(config('zvn.menu_type')));
        $ids = implode(',', Menu::all()->modelKeys());
//        $categoryIds = implode(',', Category::all()->modelKeys());
        return [
            'name' => 'bail|required|between:3,255',
            'type' => "bail|required|in:$types",
            'link' => 'bail|required_if:type,link',
//            'category_id' => "bail|required_if:type,category|in:$categoryIds",
            'category_id' => "bail|required_if:type,category",
            'post_id' => 'bail|required_if:type,post',
            'status' => 'bail|required|in:0,1',
            'parent_id' => "bail|required|in:$ids",
            'is_special_page' => "bail|required",
            'tournament_categories_id' => "bail|exclude_if:is_special_page,=,0|required|gt:0",
            
        ];
    }
    public function messages()
    {
        return [
            'tournament_categories_id.gt' => "Bạn chưa chọn chuyên trang!",
        ];
    }
}
