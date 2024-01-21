@extends('layouts.app')

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" integrity="sha384-9aF7m5+Ys93WiimO4zDnsV9HfuzeQz5Q9dbxnvZ+9Qg4odQusnZefl5n9xg5VT" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyDfBUFtFHA2zpM8+TDA/WiqE1AA6Q" crossorigin="anonymous"></script>

@section('content')
    <div class="container">
        <h1 class="my-4">Smoothies</h1>

        <!-- Search Bar -->
        <form action="{{ route('smoothies.index') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ $searchTerm ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <script>
            $(document).ready(function () {
                // Use event delegation for dynamically created buttons
                $('body').on('click', '[data-target="#filterModal"]', function () {
                    var targetModal = $(this).data('target');
                    var checkboxes = $(targetModal).find('.filter-checkbox');

                    // Reset checkboxes to their default state
                    checkboxes.prop('checked', false);

                    // Set the state of checkboxes based on the filter array
                    var filterArray = {!! json_encode((array)request('filter')) !!};
                    checkboxes.each(function () {
                        var checkbox = $(this);
                        var checkboxValue = checkbox.val();
                        if (filterArray.includes(checkboxValue)) {
                            checkbox.prop('checked', true);
                        }
                    });

                    $(targetModal).modal('show');
                });

                // Optional: Add a listener to save checkbox states when the modal is closed
                $('#filterModal').on('hidden.bs.modal', function () {
                    // Additional cleanup or actions after the modal is closed
                });
            });
        </script>
        <button type="button" class="btn btn-primary" data-target="#filterModal">
            Open Filter Modal 1
        </button>


        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
            @include('includes.filter-modal')
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Create New Smoothie Button -->
        @auth
            <a href="{{ route('smoothies.create') }}" class="btn btn-success mb-3">Create New Smoothie</a>
        @endauth

        <!-- Smoothie Cards -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($smoothies as $smoothie)
                @if($smoothie->enabled)
                    <div class="col mb-4">
                        <a href="{{ route('smoothies.show', $smoothie) }}" class="text-decoration-none text-dark">
                            <div class="card h-100">
                                <img src="{{ asset('storage/' . $smoothie->image) }}" class="card-img-top" alt="Smoothie Image">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $smoothie->name }}</h5>
                                    <p class="card-text text-muted">{{ $smoothie->ingredients }}</p>
                                    <p class="card-text">Posted by: {{ $smoothie->user->name }}</p>
                                </div>

                                @include('includes.smoothie-actions', [
                                    'smoothie' => $smoothie,
                                    'editRoute' => route('smoothies.edit', $smoothie),
                                    'deleteRoute' => route('smoothies.destroy', $smoothie),
                                ])
                            </div>
                        </a>
                    </div>
                @endif
            @empty
                <div class="col-md-12">
                    <p>No smoothies found</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
