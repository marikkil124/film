<?php

namespace App\Http\Requests\Admin\Film;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
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
            'title' => 'required|string|unique:films',
            'rating' => 'nullable',
            'video_content_id' => 'required|integer|exists:video_contents,id',
            'genres' => 'required|array|exists:genres,id'

        ];
    }

    protected function passedValidation()
    {

    }
}
