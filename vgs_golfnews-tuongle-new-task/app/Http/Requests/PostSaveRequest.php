<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSaveRequest extends FormRequest
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
        $status = implode(',', array_keys(config('zvn.template.post_status')));
        $format = implode(',', array_keys(config('zvn.template.post_format')));
        $condThumb = 'bail|required|image';
        $condTitle = 'bail|required|between:5,500|unique:posts,title';

        if ($this->id) {
            $condThumb = 'bail|image';
            $condTitle .= ",$this->id";
        }

        return [
            'published_at_display' => 'bail|required|date',
            'title' => $condTitle,
            'excerpt' => 'bail|required|max:500',
            'status' => "bail|required|in:$status",
            'format' => "bail|required|in:$format",
            'youtube_url' => 'bail|required_if:format,video',
//            'is_hot_news' => 'bail|required|in:0,1',
//            'is_on_slider' => 'bail|required|in:0,1',
            'thumbnail' => $condThumb,
            'thumbnail_large' => 'bail|image',
            'thumbnail_small' => 'bail|image',
        ];
    }
}
