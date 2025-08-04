@extends('layouts.sb2-layout')

@section('title', 'Payment Failed')

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger text-center">
        <h3 class="mb-3">❌ Payment Failed</h3>
        <p>There was an issue processing your payment. Please try again.</p>
        <a href="{{ url('/') }}" class="btn btn-danger mt-3">Return Home</a>
    </div>
</div>
@endsection
