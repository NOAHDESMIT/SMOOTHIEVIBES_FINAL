<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Models\Smoothie;

class UserController extends Controller
{
public function profile()
{
$user = auth()->user();
$smoothies = $user->smoothies;

return view('users.profile', compact('user', 'smoothies'));
}

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $imageName = time() . '.' . $profileImage->getClientOriginalExtension();
            $profileImage->storeAs('public/profile_images', $imageName);
            $user->update(['profile_image' => $imageName]);
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }


// Rest of the methods remain unchanged

public function editSmoothie(Smoothie $smoothie)
{
$this->authorize('update', $smoothie);

return view('users.edit_smoothie', compact('smoothie'));
}

public function updateSmoothie(Request $request, Smoothie $smoothie)
{
$this->authorize('update', $smoothie);

$request->validate([
'name' => 'required|string|max:255',
'ingredients' => 'required|string',
// Add other validation rules as needed
]);

$smoothie->update($request->all());

return redirect()->route('profile.smoothies')->with('success', 'Smoothie updated successfully.');
}

public function deleteSmoothie(Smoothie $smoothie)
{
$this->authorize('delete', $smoothie);

$smoothie->delete();

return redirect()->route('profile.smoothies')->with('success', 'Smoothie deleted successfully.');
}




}
