<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentLiveSaveRequest extends FormRequest
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
            'status' => 'bail|required|in:0,1',
            'tournament_categories_id' => 'gt:0',
        ];
    }
      public function messages()
    {
        return [
            'tournament_categories_id.gt' => "Bạn chưa chọn chuyên trang!",
        ];
    }
}
