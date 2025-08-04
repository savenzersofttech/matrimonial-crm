<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\PaymentLink;

class PaypalController extends Controller
{
    protected $clientId;
    protected $secret;
    protected $baseUrl;

    public function __construct()
    {
        $mode           = config('services.paypal.mode', 'sandbox');
        $this->clientId = config("services.paypal.{$mode}.client_id");
        $this->secret   = config("services.paypal.{$mode}.secret");

        $this->baseUrl = $mode === 'live'
        ? 'https://api-m.paypal.com'
        : 'https://api-m.sandbox.paypal.com';
    }


        public function showPaymentPage($token)
        {
            $paymentLink = PaymentLink::with(['profile', 'package'])->where('token', $token)->firstOrFail();

            return view('payment.paypal.preview', compact('paymentLink'));
        }


    protected function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->secret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            abort(500, 'Unable to authenticate with PayPal.');
        }
        dd($response);
        return $response->json()['access_token'];
    }

    public function createOrder(Request $request)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders", [
                'intent'              => 'CAPTURE',
                'purchase_units'      => [[
                    'amount' => [
                        'currency_code' => 'USD',
                        'value'         => $request->amount ?? '10.00',
                    ],
                ]],
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                ],
            ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to create PayPal order.'], 500);
        }

        $order = $response->json();

        $approveUrl = collect($order['links'])->firstWhere('rel', 'approve')['href'] ?? null;

        return response()->json([
            'id'          => $order['id'],
            'approve_url' => $approveUrl,
        ]);
    }

    public function capture(Request $request)
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders/{$request->query('token')}/capture");

        if ($response->failed()) {
            return redirect()->route('paypal.payment.failed')->with('error', 'Payment failed.');
        }

        $data = $response->json();

        // Optionally save payment info to DB

        return redirect()->route('paypal.payment.success')->with('success', 'Payment successful.');
    }

    public function cancel()
    {
        return redirect()->route('paypal.payment.cancel')->with('error', 'Payment cancelled.');
    }

    public function createTransaction()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $tokenResponse = $provider->getAccessToken();


         // ✅ SAFETY CHECK
    if (!isset($tokenResponse['access_token'])) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to get PayPal access token.',
            'paypal_response' => $tokenResponse
        ], 500);
    }

            // $tokenResponse = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent"              => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units"      => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value"         => "10.00",
                    ],
                ],
            ],
        ]);

        if (isset($response['id']) && $response['status'] == 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('payment.failed')->with('error', 'Something went wrong.');
    }

    public function paymentSuccess(Request $request)
{
    return view('payment.paypal.success');
}

public function paymentCancel()
{
    return view('payment.paypal.cancelled');
}

public function paymentFailed()
{
    return view('payment.paypal.failed');
}

}
