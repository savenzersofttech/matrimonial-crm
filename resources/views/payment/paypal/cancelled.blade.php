@extends('layouts.sb2-layout')

@section('title', 'Payment Cancelled')

@section('content')
<div class="container mt-5">
    <div class="alert alert-warning text-center">
        <h3 class="mb-3">⚠️ Payment Cancelled</h3>
        <p>You cancelled the payment process.</p>
        <a href="{{ url('/') }}" class="btn btn-warning mt-3">Return Home</a>
    </div>
</div>
@endsection
