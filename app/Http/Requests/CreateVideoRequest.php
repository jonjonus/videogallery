<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateVideoRequest extends Request
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
        return [
            'cloud_id' => 'required',
            'thumbnail' => 'required|max:255',
            // 'thumbnail_sm' => 'required|max:255',
            // 'thumbnail_hq' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required',
            'produced_at' => 'required|date',
            'url' => 'required',
            'count_reposts' => 'required',
            'count_watch' => 'required',
            'count_likes' => 'required',
            'ignore' => 'required'
        ];
    }
}
