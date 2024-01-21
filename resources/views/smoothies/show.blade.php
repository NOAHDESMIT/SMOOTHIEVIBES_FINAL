<!-- resources/views/smoothies/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">{{ $smoothie->name }} Details</h1>

        <div class="card">
            <img src="{{ asset('storage/' . $smoothie->image) }}" class="card-img-top" alt="Smoothie Image">
            <div class="card-body">
                <h5 class="card-title">{{ $smoothie->name }}</h5>
                <p class="card-text text-muted">{{ $smoothie->ingredients }}</p>
                <p class="card-text">Posted by: {{ $smoothie->user->name }}</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include Bootstrap and jQuery scripts here if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endpush
