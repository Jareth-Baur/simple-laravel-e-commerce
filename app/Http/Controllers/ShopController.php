<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    // This method will return the view for the shopping page
    public function index()
    {
        return view('login.index'); // You can customize the view as per your needs
    }
}
