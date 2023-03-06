<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerSaveRequest extends FormRequest
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
        $pages = implode(',', array_keys(config('zvn.banner.page')));
        $positions = implode(',', array_keys(config('zvn.banner.position')));
        $condThumb = 'bail|required|image';

        if ($this->id) {
            $condThumb = 'bail|image';
        }

        return [
            'name' => 'bail|required|between:5,255',
            'url' => 'bail|required',
//            'page' => "bail|required|in:$pages",
//            'position' => "bail|required|in:$positions",
            'status' => 'bail|required|in:0,1',
            'thumb' => $condThumb
        ];
    }
}
