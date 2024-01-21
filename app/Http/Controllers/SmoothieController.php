<?php

namespace App\Http\Controllers;

use App\Http\Requests\SmoothieUpdateRequest;
use App\Models\Smoothie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmoothieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Smoothie::query();
        $filters = [];
        $searchTerm = null;

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('ingredients', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter functionality
        if ($request->has('filter')) {
            $filters = $request->input('filter');

            foreach ($filters as $filter) {
                switch ($filter) {
                    case 'vegan':
                        $query->where('is_vegan', true);
                        break;
                    case 'oat_milk':
                        $query->where(function ($query) {
                            $query->where('ingredients', 'like', '%oat milk%')
                                ->orWhere('contains_oat_milk', true);
                        });
                        break;
                    case 'contains_milk':
                        $query->where(function ($query) {
                            $query->where('contains_regular_milk', true)
                                ->orWhere('contains_oat_milk', true);
                        });
                        break;
                    // Add more cases as needed
                }
            }
        }

        // Health category filter
        if ($request->has('health_category')) {
            $healthCategories = (array)$request->input('health_category');
            $query->whereIn('health_category', $healthCategories);
        }

        $smoothies = $query->get();

        return view('smoothies.index', compact('smoothies', 'filters', 'searchTerm'));
    }

    public function create()
    {


        // Check if the user has logged in at least 5 times
        if (Auth::check() && Auth::user()->login_count >= 5) {
            return view('smoothies.create');
        } else {
            return redirect()->route('smoothies.index')->with('error', 'You must log in at least 5 times before adding a smoothie.');
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'ingredients' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'health_category' => 'required|in:EnergyBoost,ImmuneSystem,Detox', // Add more health categories as needed
        ]);

        // Check if the user has logged in at least 5 times
        if (Auth::check() && Auth::user()->login_count >= 5) {
            $smoothie = new Smoothie($request->all());
            $smoothie->user_id = Auth::user()->id;

            $smoothie->is_vegan = $request->has('is_vegan');
            $smoothie->contains_regular_milk = $request->has('contains_regular_milk');
            $smoothie->contains_oat_milk = $request->has('contains_oat_milk');
            $smoothie->health_category = $request->input('health_category');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('smoothie_images', 'public');
                $smoothie->image = $imagePath;
            }

            $smoothie->save();

            return redirect()->route('smoothies.index')->with('success', 'Smoothie created successfully.');
        } else {
            return redirect()->route('smoothies.index')->with('error', 'You must log in at least 5 times before adding a smoothie.');
        }
    }

    public function show(Smoothie $smoothie)
    {
        return view('smoothies.show', compact('smoothie'));
    }

    public function edit(Smoothie $smoothie)
    {
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->id == $smoothie->user_id)) {
            return view('smoothies.edit', compact('smoothie'));
        } else {
            return redirect()->route('smoothies.index')->with('error', 'You do not have permission to edit this smoothie.');
        }
    }

    public function update(SmoothieUpdateRequest $request, Smoothie $smoothie)
    {
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->id == $smoothie->user_id)) {
            try {
                $data = $request->validated(); // Use validated data

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('smoothie_images', 'public');
                    $data['image'] = $imagePath;
                }

                // Handle boolean attributes
                $data['is_vegan'] = $request->has('is_vegan');
                $data['contains_regular_milk'] = $request->has('contains_regular_milk');
                $data['contains_oat_milk'] = $request->has('contains_oat_milk');

                // Update the smoothie
                $smoothie->update($data);

                return redirect()->route('smoothies.index')->with('success', 'Smoothie updated successfully.');
            } catch (ValidationException $e) {
                return redirect()->back()->withErrors($e->errors())->withInput();
            } catch (\Exception $e) {
                return redirect()->route('smoothies.index')->with('error', 'An error occurred during the update: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('smoothies.index')->with('error', 'You do not have permission to update this smoothie.');
        }
    }

    public function destroy(Smoothie $smoothie)
    {
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->id == $smoothie->user_id)) {
            $smoothie->delete();
            return redirect()->route('smoothies.index')->with('success', 'Smoothie deleted successfully.');
        } else {
            return redirect()->route('smoothies.index')->with('error', 'You do not have permission to delete this smoothie.');
        }
    }

    public function toggle(Request $request, Smoothie $smoothie)
    {
        if (auth()->user()->id == $smoothie->user_id) {
            $smoothie->update([
                'enabled' => !$smoothie->enabled,
            ]);

            return back()->with('success', 'Smoothie status toggled successfully.');
        }

        return back()->with('error', 'You do not have permission to toggle this smoothie.');
    }
}
