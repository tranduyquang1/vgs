<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    private $table = 'post';

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
        $id = $this->id;

        $condName = "bail|required|between:5,100|unique:$this->table,name";
        $condThumb = 'bail|required|image|max:2000';

        if (!empty($id)) {
            $condName .= ",$id";
            $condThumb = 'bail|image|max:2000';
        }

        return [
            'name' => $condName,
            'description' => 'bail|required|min:5',
            'content' => 'bail|required|min:5',
            'status' => 'bail|required|in:active,inactive',
            'type' => 'bail|required|in:featured,normal',
            'category_id' => 'bail|required|not_in:default',
            'thumb' => $condThumb
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'description' => 'Mô tả',
            'content' => 'Nội dung',
            'status' => 'Trạng thái',
            'type' => 'Kiểu bài',
            'category_id' => 'Danh mục',
            'thumb' => 'Ảnh',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được rỗng',
            'between' => ':attribute giá trị :input không nằm trong khoảng :min - :max.',
            'in' => ':attribute: phải khác giá trị mặc định',
            'not_in' => ':attribute phải khác giá trị mặc định',
        ];
    }
}
