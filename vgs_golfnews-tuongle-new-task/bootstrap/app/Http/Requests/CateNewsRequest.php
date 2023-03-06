<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CateNewsRequest extends FormRequest
{
    private $table = 'cate_news';

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
        return [
            'name' => 'bail|required',
            'slug' => 'bail|required',
            'parent_id' => 'bail|required',
            'status' => 'bail|required|in:active,inactive',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'slug' => 'Slug',
            'status' => 'Trạng thái',
            'parent_id' => 'Parent',
        ];
    }

    public function messages()
    {
        return [
            'required' => ' :attribute không được rỗng',
            'between' => ' :attribute giá trị :input không nằm trong :min - :max.',
            'in' => ' :attribute: phải khác giá trị mặc định',
            'not_id' => ' :attribute: phải khác giá trị mặc định',
            'numeric' => ' :attribute: phải là số',
            'min' => ' :attribute: nhỏ nhất là :min',
        ];
    }
}
