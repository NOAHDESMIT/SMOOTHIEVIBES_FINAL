<?php

// app/Http/Requests/SmoothieUpdateRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmoothieUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'contains_oat_milk' => 'boolean',
            'contains_regular_milk' => 'boolean',
            'is_vegan' => 'boolean',
            'health_category' => 'required|in:EnergyBoost,ImmuneSystem,Detox',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
