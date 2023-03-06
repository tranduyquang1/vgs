<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilesRequest extends FormRequest
{
    private $table = 'files';

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
        $condThumb = 'bail|required|max:4096';
        if (!empty($id))
            $condThumb = 'bail|max:4096';

        return [
            'description' => 'bail|required|between:5,255',
            'file' => $condThumb,
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'Mô tả',
            'files' => 'Tập tin'
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
