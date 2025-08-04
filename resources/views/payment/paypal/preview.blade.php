@extends('layouts.payment')

@section('title', 'Pay with PayPal')

@section('content')
<div class="container-xl px-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-9 mt-5">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h4 class="text-primary">Elitebandhan Payment</h4>
                    <p class="text-muted">Please review the details before proceeding to payment.</p>

                    {{-- Example Details --}}
                    <p><strong>Name:</strong> {{ $paymentLink->profile->name ?? 'N/A' }}</p>
                    <p><strong>Plan:</strong> {{ $paymentLink->package->name ?? 'N/A' }}</p>
                    <p><strong>Amount:</strong> {{ $paymentLink->final_amount }} {{ $paymentLink->currency }}</p>

                    <a href="{{ route('paypal.create.order', ['token' => $paymentLink->token]) }}" class="btn btn-primary mt-3">
    Proceed to Pay
</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
