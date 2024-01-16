<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'name' => [
                'required',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone_number' => [
                'required',
                'max:255',
            ],
            'is_active' => [
                'required',
                Rule::in(array_keys(seller_account_status()))
            ],
            'description' => [
                'max:5000',
            ],
            'image' => [
                'image',
                'max:2048'
            ],
        ];
    }
}
