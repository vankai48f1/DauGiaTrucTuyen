<?php

namespace App\Http\Requests\Withdrawal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WithdrawalRequest extends FormRequest
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
        $wallet = $this->route('wallet');
        $rules = [
            'amount' => [
                "required",
                "numeric",
                "min:{$wallet->currency->min_withdrawal}"
            ],
            'withdrawal_policy' => [
                'required'
            ],
            'payment_method' => 'required',
            'address' => Rule::requiredIf(function () {
                return $this->payment_method == PAYMENT_METHOD_PAYPAL;
            })
        ];

        if ($this->get('payment_method') == PAYMENT_METHOD_BANK) {
            $rules['bank_account_id'] = [
                'required',
                Rule::exists('bank_accounts', 'id')
                    ->where('is_active', ACTIVE)
                    ->where('is_verified', VERIFICATION_STATUS_APPROVED)
            ];
        }

        return $rules;
    }
}
