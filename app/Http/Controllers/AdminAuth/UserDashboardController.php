<?php

namespace App\Http\Controllers\AdminAuth;

use App\Models\Product; // Import the Product model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Import Request for handling query parameters

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get the sort direction from the request, defaulting to 'asc' (A-Z)
        $sort = $request->get('sort', 'asc');

        // Fetch products and sort them by name in the selected order (A-Z or Z-A)
        $products = Product::orderBy('name', $sort)->get();

        // Pass the products and the selected sort order to the view
        return view('dashboard', compact('products', 'sort'));
    }

    public function show(Request $request)
    {
        // Get the sort direction from the request, defaulting to 'asc' (A-Z)
        $sort = $request->get('sort', 'asc');

        // Fetch products and sort them by name in the selected order (A-Z or Z-A)
        $products = Product::orderBy('name', $sort)->get();

        // Pass the products and the selected sort order to the view
        return view('products.show', compact('products', 'sort'));
    }
}
