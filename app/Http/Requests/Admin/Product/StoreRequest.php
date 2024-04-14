<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'product.description'=>'required',
            'product.price'=>'required',
            'images'=>'nullable|array',
            'images.*'=>'nullable|image',
        ];

    }

    protected function passedValidation()
    {

        $this->merge([
            'images' => $this->images ?? [],
        ]);
    }
}
