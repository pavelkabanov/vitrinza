<?php

namespace App\Http\Controllers;

use Auth;
use App\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function show()
    {
        
        return Item::whereHas('likes', function ($query) {
            $query->where('user_id', Auth::id())
                  ->where('likeable_type', 'App\Item');
        })->get();
    }
}
