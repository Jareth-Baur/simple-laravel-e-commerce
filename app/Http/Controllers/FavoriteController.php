<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display the list of active favorite products.
     */
    public function index()
    {
        // Get the authenticated user's active favorite products (exclude inactive ones from the view)
        $favorites = Favorite::where('user_id', Auth::id())
                             ->where('status', 'active') // Only show active favorites
                             ->with('product') // Load the associated product
                             ->get();
                                                 
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle a product as favorite or remove it (set status to inactive).
     */
    public function toggle(Request $request)
    {
        $productId = $request->input('product_id');
        
        // Check if the product is already a favorite
        $favorite = Favorite::where('user_id', Auth::id())->where('product_id', $productId)->first();
        
        if ($favorite) {
            // If it is a favorite, set its status to inactive (without deleting the record)
            $favorite->status = 'inactive';
            $favorite->save();
            $message = 'Product removed from favorites.';
        } else {
            // If not, add to favorites with active status
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'status' => 'active', // Default status when added
            ]);
            $message = 'Product added to favorites.';
        }

        return response()->json(['message' => $message]);
    }

    /**
     * Mark a product as inactive after it's added to the cart (without deleting the record).
     */
    public function removeFromFavorites(Request $request)
    {
        $productId = $request->input('product_id');
        
        // Find the product in the favorites table
        $favorite = Favorite::where('user_id', Auth::id())->where('product_id', $productId)->first();
        
        if ($favorite) {
            // Mark the product as inactive without removing it from the favorites table
            $favorite->status = 'inactive';
            $favorite->save();
            return response()->json(['message' => 'Product marked as inactive in favorites after being added to cart.']);
        }

        return response()->json(['message' => 'Product not found in favorites.'], 404);
    }
}
