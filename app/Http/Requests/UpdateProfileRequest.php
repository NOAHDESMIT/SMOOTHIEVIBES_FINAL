<?php

// app/Http/Requests/UpdateProfileRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // Add other fields and validation rules as needed
        ];
    }
}
