<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($user)
    {
        $user = User::byIdOrUsername($user);

        return view('user.page')->with('user', $user);
    }

    public function items($user)
    {
        $user = User::byIdOrUsername($user);

        $items = $user->items()->paginate(16);

        return view('user.items', compact('items', 'user'));
    }

}
