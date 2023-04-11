<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function showFavorites()
    {
        $items = Auth::user()->favoriteItems()->paginate(16);
        
        return view('user.favorites')->with('items', $items);
    }
}
