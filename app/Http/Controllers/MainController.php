<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class MainController extends Controller
{
    public function index()
    {

        $date = new Carbon;
        $date->subDays(20);

        $items1 = Item::where('created_at', '<', $date->toDateTimeString())->orderBy('created_at', 'desc')->get();

        $items3 = Item::withCount('likes')->has('likes', '<', 2)->where('created_at', '>', $date->toDateTimeString())->orderBy('likes_count', 'desc')->get();
        $items1 = $items3->merge($items1);

        $items2 = Item::withCount('likes')->has('likes', '>', 1)->where('created_at', '>', $date->toDateTimeString())->orderBy('likes_count', 'desc')->get();

        $items = $items2->merge($items1);
        $items = $this->paginate($items, 8);
        $items->defaultView('vendor.pagination.default');

        return view('welcome')->with('items', $items);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function sortedbylikes()
    {
        $items = Item::all()->sortByDesc(function($item)
        {
            return $item->likes->count();
        });

        return view('welcome')->with('items', $items);
    }

}
