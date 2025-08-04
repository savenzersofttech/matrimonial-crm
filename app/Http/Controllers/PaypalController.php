<?php
namespace App\Http\Controllers;

use App\Models\PaymentLink;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    protected $clientId;
    protected $secret;
    protected $baseUrl;

    public function __construct()
    {
        $mode = config('services.paypal.mode', 'sandbox');

        $this->clientId = config("services.paypal.{$mode}.client_id");
        $this->secret   = config("services.paypal.{$mode}.secret");

        if (! $this->clientId || ! $this->secret) {
            abort(500, 'PayPal credentials not set in config/services.php');
        }

        $this->baseUrl = $mode === 'live'
        ? 'https://api-m.paypal.com'
        : 'https://api-m.sandbox.paypal.com';
    }

    public function showPaymentPage($token)
    {
        try {
            $paymentLink = PaymentLink::with(['profile', 'package'])->where('token', $token)->firstOrFail();
            return view('payment.paypal.preview', compact('paymentLink'));
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Payment link not found or expired.');
        }
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

        return $response->json()['access_token'];
    }

    public function createOrder($token)
    {
        $paymentLink = PaymentLink::where('token', $token)->firstOrFail();
        $amount      = number_format($paymentLink->final_amount, 2, '.', '');
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)->post("{$this->baseUrl}/v2/checkout/orders", [
            'intent'              => 'CAPTURE',
            'purchase_units'      => [[
                'amount' => [
                    'currency_code' => $paymentLink->currency ?? 'USD',
                    'value'         => $amount,
                ],
            ]],
            'application_context' => [
                'return_url' => route('paypal.payment.success'),
                'cancel_url' => route('paypal.payment.cancel'),
            ],
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Failed to create PayPal order.');
        }

        $order      = $response->json();
        $approveUrl = collect($order['links'])->firstWhere('rel', 'approve')['href'] ?? null;

        return $approveUrl
        ? redirect()->away($approveUrl)
        : back()->with('error', 'Approval URL not found.');
    }

    public function paymentSuccess(Request $request)
    {
        $token = $request->query('token');
        if (! $token) {
            return redirect()->route('paypal.payment.failed')->with('error', 'Missing PayPal token.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $accessToken = $provider->getAccessToken();

        if (! isset($accessToken['access_token'])) {
            return redirect()->route('paypal.payment.failed')->with('error', 'PayPal auth failed.');
        }

        $response = $provider->capturePaymentOrder($token);

        if (! isset($response['status']) || $response['status'] !== 'COMPLETED') {
            return redirect()->route('paypal.payment.failed')->with('error', 'Payment not completed.');
        }

        $paymentLink = PaymentLink::where('token', $token)->first();
        if (! $paymentLink) {
            return redirect()->route('paypal.payment.failed')->with('error', 'Payment link not found.');
        }

        $paymentLink->update([
            'status'           => 'Paid',
            'transaction_id'   => $response['id'],
            'gateway_response' => json_encode($response),
            'paid_at'          => now(),
        ]);

        // ✅ Check if WelcomeCall already exists for this profile
        $existingCall = \App\Models\WelcomeCall::where('profile_id', $paymentLink->profile_id)->first();
        if (! $existingCall) {
            \App\Models\WelcomeCall::create([
                'profile_id'      => $paymentLink->profile_id,
                'payment_link_id' => $paymentLink->id,
                'user_id'         => $paymentLink->user_id ?? auth()->id(), // Fallback to current user
                'status'          => 'Pending',
                'call_time'       => now()->addDay(), // optional: schedule next day
                'outcome'         => null,
                'notes'           => 'Auto-created after successful payment.',
            ]);
        }

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
