<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'=>'required|string',
            'email'=>'required|string',
            'password'=>'required|string|same:password_confirmation',
            'password_confirmation'=>'required|string',
        ];
    }

//    protected function passedValidation()
//    {
//        return  $this->replace([
//                'name' => $this->name,
//                'email' => $this->email,
//                'password' => $this->password,
//            ]
//
//        );
//    }
}
