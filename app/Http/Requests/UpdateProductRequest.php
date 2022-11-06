<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'image' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường bắt buộc',
            'price.required' => 'Trường bắt buộc',
            'amount.required' => 'Trường bắt buộc',
            'description.required' => 'Trường bắt buộc',
            'image.required' => 'Trường bắt buộc',
            
        ];
    }
}
