<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        $items = $category->items;

        $items = $this->paginate($items, 8);

        return view('category', compact('items', 'category'));
    }

    public function getsubcategories($id)
    {
        $category = Category::where('id', $id)->first();
        if($category->isHasSubcategories())
        {
            return $category->subcategories->toJson();
        }
        else return null;
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
