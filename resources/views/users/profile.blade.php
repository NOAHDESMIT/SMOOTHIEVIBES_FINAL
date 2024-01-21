@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>

        <!-- Display User Information -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">User Information</h5>
                <div class="d-flex align-items-center">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="Profile Image" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover; margin-right: 15px;">
                    @endif
                    <div>
                        <p>Name: {{ $user->name }}</p>
                        <p>Email: {{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update User Information Form -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Update User Information</h5>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control-file">

                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Display User Smoothies -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Smoothies</h5>

                <div class="list-group">
                    @forelse($smoothies as $smoothie)
                        <div class="list-group-item" data-smoothie-id="{{ $smoothie->id }}">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">{{ $smoothie->name }}</h6>
                            </div>
                            <p class="mb-1">Ingredients: {{ $smoothie->ingredients }}</p>

                            <div class="btn-group" role="group" aria-label="Smoothie Actions">
                                <a href="{{ route('smoothies.edit', $smoothie) }}" class="btn btn-warning">Edit</a>

                                <form action="{{ route('smoothies.destroy', $smoothie) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this smoothie?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>

                                <!-- Toggle Button -->
                                <form action="{{ route('smoothies.toggle', $smoothie) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn {{ $smoothie->enabled ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $smoothie->enabled ? 'Enabled' : 'Disabled' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="list-group-item">No smoothies found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
