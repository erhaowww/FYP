<?php

namespace App\Http\Controllers;
use Auth;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('braintree.environment'),
            'merchantId' => config('braintree.merchantId'),
            'publicKey' => config('braintree.publicKey'),
            'privateKey' => config('braintree.privateKey'),
            'accessToken' => config('braintree.paypalAccessToken'),
        ]);
    }

    public function processPayment(Request $request)
    {
        \Log::info('Request: ' . json_encode($request->all()));
        if (empty($request->payment_method_nonce)) {
            return response()->json(['success' => false, 'message' => 'Payment method nonce is missing.']);
        }
        $amount = 10.00; // Or any other logic to determine the amount

        // Determine the card type
        $cardType = $this->determineCardType($request->cardNumber);

        // Proceed with the payment transaction
        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $request->payment_method_nonce,
            'options' => ['submitForSettlement' => true]
        ]);

        if ($result->success) {
            // Transaction successful
            Log::info('Transaction successful: ', ['transaction' => $result->transaction, 'cardType' => $cardType]);
            return response()->json(['success' => true, 'transaction' => $result->transaction, 'cardType' => $cardType]);
        } else {
            // Transaction failed
            Log::error('Transaction failed: ', ['message' => $result->message, 'cardType' => $cardType]);
            return response()->json(['success' => false, 'message' => $result->message, 'cardType' => $cardType]);
        }
    }


    protected function determineCardType($cardNumber)
    {
        if (empty($cardNumber)) {
            return 'visa';
        }

        // Regular expressions for different card types
        $cardPatterns = [
            'visa' => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'mastercard' => '/^5[1-5][0-9]{14}$/',
            'amex' => '/^3[47][0-9]{13}$/',
            'discover' => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
            'troy' => '/^9792[0-9]{12}$/',
            // Add more card types here if needed
        ];

        foreach ($cardPatterns as $type => $pattern) {
            if (preg_match($pattern, $cardNumber)) {
                return $type;
            }
        }

        return 'visa';
    }

    // Generate a client token
    public function clientToken()
    {
        $clientToken = $this->gateway->clientToken()->generate();
        return response()->json(['token' => $clientToken]);
    }

}

