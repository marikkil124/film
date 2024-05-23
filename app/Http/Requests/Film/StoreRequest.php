<?php

namespace App\Http\Requests\Film;

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
            'title'=>'nullable|string',
            'title_eng'=>'nullable|string',
            'url'=>'nullable|string',
            'year'=>'nullable|integer',
            'genres'=>'nullable|array',
            'type_number'=>'nullable|integer|exists:video_contents,type_number',
            'film_id_api'=>'nullable|integer',
        ];
    }


}
