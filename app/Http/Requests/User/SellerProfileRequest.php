<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SellerProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return auth()->check() && (
            $this->isMethod('post') ?
                auth()->user()->assigned_role == USER_ROLE_USER :
                auth()->user()->assigned_role == USER_ROLE_SELLER
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'string|max:255',
            'image' => 'image|mimes:jpeg,png|max:2048',
            'phone_number'=> [
                'required',
                'max:25',
                Rule::unique('sellers', 'phone_number')->ignore((optional(auth()->user()->seller))->id),
            ],
            'email'=> [
                'required',
                'email',
                'between:5,255',
                Rule::unique('sellers', 'email')->ignore((optional(auth()->user()->seller))->id),
            ],
        ];
    }
}
