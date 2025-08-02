@extends('layouts.sb2-layout')

@section('title', 'Payment Successful')

@section('content')
<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h3 class="mb-3">🎉 Payment Successful</h3>
        <p>Thank you! Your payment has been processed successfully.</p>
        <a href="{{ url('/') }}" class="btn btn-success mt-3">Go to Dashboard</a>
    </div>
</div>
@endsection
