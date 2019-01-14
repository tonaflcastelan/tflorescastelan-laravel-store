<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'name'              => 'required',
            'price'             => 'required|numeric',
            'description'       => 'required',
            'category_id'       => 'required|not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                 => 'The name is required',
            'price.required'                => 'The price is required',
            'description.required'          => 'The description is required',
            'category_id.required'          => 'The category is required',
        ];
    }
}
