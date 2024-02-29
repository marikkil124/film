<?php

namespace App\Http\Requests\Transaction;

use App\Models\Transaction;
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
        $types = implode(',',array_keys(Transaction::TYPES));
        $statuses = implode(',',array_keys(Transaction::STATUSES));
        return [
            'amount'=>'required|integer',
            'type'=>'required|integer|in:'.$types,
            'status'=>'nullable|integer|in:'.$statuses,
            'order_id'=>'required|integer|exists:orders,id'
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),

        ]);
    }
}
