<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionsRequest extends FormRequest
{
    private $table = 'suggestions';

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
            'content' => 'bail|required|between:5,255',
            'status' => 'bail|in:active,inactive',
        ];
    }

    public function attributes()
    {
        return [
            'content' => 'Nội dung',
            'status' => 'Trạng thái',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được rỗng',
            'between' => ':attribute giá trị :input không nằm trong khoảng :min - :max.',
            'in' => ':attribute: phải khác giá trị mặc định'
        ];
    }

}
