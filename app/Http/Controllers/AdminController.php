<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Your logic for the admin dashboard goes here
        return view('admin.dashboard'); // You'll need to create this view
    }
}
