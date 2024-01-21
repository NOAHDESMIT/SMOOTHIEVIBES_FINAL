<!-- resources/views/smoothies/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Edit Smoothie</h1>

        <form action="{{ route('smoothies.update', ['smoothie' => $smoothie]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $smoothie->name }}" required>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea name="ingredients" class="form-control" required>{{ $smoothie->ingredients }}</textarea>
            </div>

            <div class="form-group">
                <label for="contains_oat_milk">Contains Oat Milk</label>
                <input type="checkbox" name="contains_oat_milk" class="form-check-input" {{ $smoothie->contains_oat_milk ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="contains_regular_milk">Contains Regular Milk</label>
                <input type="checkbox" name="contains_regular_milk" class="form-check-input" {{ $smoothie->contains_regular_milk ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="is_vegan">Is Vegan</label>
                <input type="checkbox" name="is_vegan" value="1" class="form-check-input" {{ $smoothie->is_vegan ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="healthCategory">Health Category:</label>
                <select id="healthCategory" name="health_category" class="form-control">
                    <option value="EnergyBoost" {{ $smoothie->health_category === 'EnergyBoost' ? 'selected' : '' }}>Energy Boost</option>
                    <option value="ImmuneSystem" {{ $smoothie->health_category === 'ImmuneSystem' ? 'selected' : '' }}>Immune System</option>
                    <option value="Detox" {{ $smoothie->health_category === 'Detox' ? 'selected' : '' }}>Detox</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control-file" id="imageInput">
                @if($smoothie->image)
                    <img src="{{ asset('storage/' . $smoothie->image) }}" alt="Current Image" id="currentImage" style="max-width: 100%;">
                @else
                    <p>No image uploaded</p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Smoothie</button>
        </form>
    </div>

    <script>
        // JavaScript to update image preview
        document.getElementById('imageInput').addEventListener('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            var image = document.getElementById('currentImage');

            reader.onload = function(){
                image.src = reader.result;
            };

            reader.readAsDataURL(input.files[0]);
        });
    </script>
@endsection
