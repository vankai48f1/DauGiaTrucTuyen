<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyWithdrawalOptionsRequest extends FormRequest
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
            'min_withdrawal' => [
                'required',
                'numeric',
                'between:' . ($this->currency->type === CURRENCY_TYPE_CRYPTO ? '0.00000001,99999999999.99999999' : '0.01,99999999999.99'),
            ],
            'withdrawal_status' => [
                'required',
                Rule::in(array_keys(active_status()))
            ],
            'withdrawal_fee' => [
                'required',
                'numeric',
                'min:0',
                Rule::requiredIf(function () {
                    return $this->get('withdrawal_status') == ACTIVE;
                }),
            ],
            'withdrawal_fee_type' => [
                'required',
                Rule::in(array_keys(fee_types()))
            ]
        ];
    }
}
