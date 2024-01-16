<?php

namespace App\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyPaymentMethodsRequest extends FormRequest
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
        $paymentMethods = ($this->currency->type === CURRENCY_TYPE_FIAT) ? fiat_payment_methods() : crypto_payment_methods();

        $rules = [
            'payment_methods' => ['required'],
            'payment_methods.*' => Rule::in(array_keys($paymentMethods))
        ];

        if (
            $this->currency->type === CURRENCY_TYPE_FIAT &&
            in_array(PAYMENT_METHOD_BANK, $this->get('payment_methods', []))
        ) {
            $rules['banks'] = ['required'];
            $rules['banks.*'] = [
                Rule::exists('bank_accounts', 'id')->where(function ($query) {
                    $query->whereNull('user_id');
                    $query->where('is_active', ACTIVE);
                })
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
//            'payment_methods.*' => __('payment method(s)'),
            'banks.*' => __('bank(s)'),
        ];
    }
}
