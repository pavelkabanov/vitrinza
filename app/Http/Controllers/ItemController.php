<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required|max:80',
            'description' => 'max:1000',
            'myimage' => 'required|image',
        ]);

        if ($request->file('myimage')->isValid()) {
            $file = $request->file('myimage');
            $ext = $file->guessClientExtension();
            $path = $file->storeAs('public/pictures', auth()->id() . uniqid('-', true) . time() . '.' . $ext);

            $item = $request->user()->items()->create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $path,
                'link' => $request->link,
            ]);

            $item->categories()->attach($request->category);
            $item->categories()->attach($request->subcategory);

            $request->session()->flash('alert-success', 'Новая вещь добавлена!');
        }

        return back();
    }

    public function show(Item $item)
    {

        Carbon::setLocale('ru');

        return view('item.show')->with('item', $item);
    }

    public function destroy(Item $item)
    {
        $this->authorize('destroy', $item);

        $item->delete();

        return back();
    }

    public function restore($item)
    {
        $item = Item::onlyTrashed()->where('slug', $item)->firstOrFail();

        $this->authorize('destroy', $item);

        $item->restore();

        return back();
    }
}
