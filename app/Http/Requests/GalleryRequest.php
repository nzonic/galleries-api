<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ArrayAtLeastOneRequired;

class GalleryRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'description' => 'max:1000',
            'images' => ['required', new ArrayAtLeastOneRequired],
            'images.*.url' => ['url', 'regex:/(https?)(\:\/\/)(www\.)?[\w.-]+\.[a-zA-Z]+\/((([\w\/-]+)\/)?[\w.-]+\.(png|jpe?g)$)/']
        ];
    }
}
