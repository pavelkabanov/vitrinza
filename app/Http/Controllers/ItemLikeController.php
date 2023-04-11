<?php

namespace App\Http\Controllers;

use Auth;
use App\Item;
use Illuminate\Http\Request;

class ItemLikeController extends Controller
{
    public function store(Item $item)
    {
        Auth::user()->likeItems()->syncWithoutDetaching([$item->id]);

        return back();
    }

    public function destroy(Item $item)
    {
        Auth::user()->likeItems()->detach($item);

        return back();
    }

}
