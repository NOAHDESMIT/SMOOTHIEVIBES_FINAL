@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Create Smoothie</h1>

        <form action="{{ route('smoothies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea name="ingredients" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="contains_oat_milk">Contains Oat Milk</label>
                <input type="checkbox" name="contains_oat_milk" class="form-check-input">
            </div>

            <div class="form-group">
                <label for="contains_regular_milk">Contains Regular Milk</label>
                <input type="checkbox" name="contains_regular_milk" class="form-check-input">
            </div>

            <div class="form-group">
                <label for="is_vegan">Is Vegan</label>
                <input type="checkbox" name="is_vegan" value="1" class="form-check-input">
            </div>

            <div class="form-group">
                <label for="healthCategory">Health Category:</label>
                <select id="healthCategory" name="health_category" class="form-control">
                    <option value="EnergyBoost">Energy Boost</option>
                    <option value="ImmuneSystem">Immune System</option>
                    <option value="Detox">Detox</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Create Smoothie</button>
        </form>
    </div>
@endsection
