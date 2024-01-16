<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyRequest extends FormRequest
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
            'name'=> [
                'required',
                'max:255',
                Rule::unique('currencies', 'name')->ignore($this->route()->parameter('currency')),
            ],
            'symbol'=> [
                'required',
                'max:255',
                Rule::unique('currencies', 'symbol')->ignore($this->route()->parameter('currency')),
            ],
            'type' => [
                Rule::requiredIf(function () {
                    return !$this->route()->parameter('currency');
                }),
                Rule::in(array_keys(currency_types()))
            ],
            'logo'=> [
                'image:jpeg,png,jpg',
                'max:1024',
            ],
            'is_active' => [
                'required',
                Rule::in(array_keys(active_status()))
            ],
        ];
    }
}
