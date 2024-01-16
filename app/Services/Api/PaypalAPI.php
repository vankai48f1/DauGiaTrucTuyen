<?php

namespace App\Services\Api;

use App\Services\Logger\Logger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaypalAPI
{
    private $clientID;
    private $clientSecret;
    private $webhookID;
    private $apiUrl;

    public function __construct()
    {
        $this->clientID = settings('paypal_client_id');
        $this->clientSecret = settings('paypal_secret');
        $mode = settings('paypal_mode');
        $this->apiUrl = $mode === 'live' ? 'https://api.paypal.com' : 'https://api.sandbox.paypal.com';
        $this->webhookID = settings('paypal_webhook_id');
    }

    private function _getAccessToken(): string
    {
        if (cache()->has('paypal_access_token')) {
            return cache()->get('paypal_access_token');
        }

        try {
            $response = Http::withBasicAuth($this->clientID, $this->clientSecret)
                ->asForm()
                ->post($this->apiUrl . '/v1/oauth2/token', ['grant_type' => 'client_credentials']);

            $response->throw();

            if ($response->successful()) {
                $responseData = $response->json();
                cache()->put('paypal_access_token', $responseData['access_token'], now()->addSeconds($responseData['expires_in']));

                return $responseData['access_token'];
            }
        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][PaypalAPI][_getAccessToken]');
        }

        return '';
    }

    public function _isValidatedCurrency($currency): bool
    {
        return in_array($currency, ['AUD', 'BRL', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'INR', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK', 'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD']);
    }

    public function createOrder($payload): array
    {
        try {
            if (isset($payload['currency']) && !$this->_isValidatedCurrency($payload['currency'])) {
                throw new Exception(__("The given currency is not support by paypal."));
            }

            $response = Http::withToken($this->_getAccessToken())
                ->acceptJson()
                ->post($this->apiUrl . '/v2/checkout/orders', [
                    "intent" => isset($payload['intent']) && !empty($payload['intent']) ? $payload['intent'] : "CAPTURE",
                    "application_context" => [
                        'return_url' => isset($payload['return_url']) ? $payload['return_url'] : '',
                        'cancel_url' => isset($payload['cancel_url']) ? $payload['cancel_url'] : '',
                        'brand_name' => isset($payload['brand_name']) ? $payload['brand_name'] : null,
                        'user_action' => 'PAY_NOW',
                    ],
                    "purchase_units" => [
                        [
                            "reference_id" => $payload['reference_id'],
                            "amount" => [
                                "currency_code" => isset($payload['currency']) ? $payload['currency'] : 'USD',
                                "value" => $payload['amount'],
                            ]
                        ]
                    ]
                ]);

            $response->throw();

            if ($response->successful()) {
                return [
                    RESPONSE_STATUS_KEY => true,
                    RESPONSE_DATA_KEY => $response->json(),
                ];
            }
        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][PaypalAPI][createOrder]');
        }

        return [
            RESPONSE_STATUS_KEY => false
        ];
    }

    public function showOrder($orderId): array
    {
        try {
            $response = Http::withToken($this->_getAccessToken())
                ->acceptJson()
                ->get($this->apiUrl . '/v2/checkout/orders/'.$orderId);

            $response->throw();

            if ($response->successful()) {
                return [
                    RESPONSE_STATUS_KEY => true,
                    RESPONSE_DATA_KEY => $response->json(),
                ];
            }
        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][PaypalAPI][showOrder]');
        }

        return [
            RESPONSE_STATUS_KEY => false
        ];
    }

    public function captureOrder($orderId): array
    {
        try {
            $response = Http::withToken($this->_getAccessToken())
                ->acceptJson()
                ->withBody('{}', 'application/json')
                ->post($this->apiUrl . '/v2/checkout/orders/' . $orderId . '/capture');

            $response->throw();

            if ($response->successful()) {
                return [
                    RESPONSE_STATUS_KEY => true,
                    RESPONSE_DATA_KEY => $response->json(),
                ];
            }
        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][PaypalAPI][captureOrder]');
        }

        return [
            RESPONSE_STATUS_KEY => false
        ];
    }

    public function payout(array $payload): array
    {
        try {
            if (isset($payload['currency']) && !$this->_isValidatedCurrency($payload['currency'])) {
                throw new Exception(__("The given currency is not support by paypal."));
            }

            $response = Http::withToken($this->_getAccessToken())
                ->acceptJson()
                ->post($this->apiUrl . '/v1/payments/payouts', [
                    "sender_batch_header" => [
                        "sender_batch_id" => Str::uuid()->toString(),
                        "email_subject" => isset($payload["email_subject"]) ? $payload["email_subject"] : __("You just have a payout.)")
                    ],
                    "items" => [
                        [
                            "recipient_type" => "EMAIL",
                            "receiver" => $payload["receiver"],
                            "amount" => [
                                "currency" => isset( $payload["currency"] ) ? $payload["currency"] : "USD",
                                "value" => $payload["amount"]
                            ],
                            "sender_item_id" => Str::uuid()->toString(),
                            "note" => isset($payload["note"]) ? $payload["note"] : "POSPYO001",
                        ]
                    ]
                ]);

            $response->throw();

            if ($response->successful()) {
                return [
                    RESPONSE_STATUS_KEY => true,
                    RESPONSE_DATA_KEY => $response->json(),
                ];
            }
        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][PaypalAPI][payout]');
        }

        return [
            RESPONSE_STATUS_KEY => false
        ];
    }

    public function verifyWebhookSignature(Request $request): array
    {
        try {
            $response = Http::withToken($this->_getAccessToken())
                ->acceptJson()
                ->post($this->apiUrl . '/v1/notifications/verify-webhook-signature', [
                    "auth_algo" => $request->header('PAYPAL-AUTH-ALGO'),
                    "cert_url" => $request->header('PAYPAL-CERT-URL'),
                    "transmission_id" => $request->header('PAYPAL-TRANSMISSION-ID'),
                    "transmission_sig" => $request->header('PAYPAL-TRANSMISSION-SIG'),
                    "transmission_time" => $request->header('PAYPAL-TRANSMISSION-TIME'),
                    "webhook_id" => $this->webhookID,
                    "webhook_event" => $request->all(),
                ]);

            $response->throw();

            if ($response->successful()) {
                return [
                    RESPONSE_STATUS_KEY => true,
                    RESPONSE_DATA_KEY => $response->json(),
                ];
            }
        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][PaypalAPI][verifyWebhookSignature]');
        }

        return [
            RESPONSE_STATUS_KEY => false
        ];
    }
}
