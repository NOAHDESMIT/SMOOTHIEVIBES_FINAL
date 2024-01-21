<!-- resources/views/users/edit_smoothie.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Smoothie</h1>
        <form action="{{ route('user.updateSmoothie', $smoothie) }}" method="POST">
            @csrf
            <!-- Add your smoothie edit form fields here -->
            <label for="name">Smoothie Name:</label>
            <input type="text" name="name" value="{{ $smoothie->name }}" required>
            <!-- Add more fields as needed -->
            <button type="submit">Update Smoothie</button>
        </form>
    </div>
@endsection
