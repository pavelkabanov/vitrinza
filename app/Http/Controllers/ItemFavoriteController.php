<?php

namespace App\Http\Controllers;

use Auth;
use App\Item;
use Illuminate\Http\Request;

class ItemFavoriteController extends Controller
{
    public function store(Item $item)
    {
        Auth::user()->favoriteItems()->syncWithoutDetaching([$item->id]);

        return back();
    }

    public function destroy(Item $item)
    {
        Auth::user()->favoriteItems()->detach($item);

        return back();
    }

    public function getCount(Item $item)
    {
        dd($item->favorites()->count());
    }

}
