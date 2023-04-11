<?php

namespace App\Policies;

use App\User;
use App\Item;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, Item $item)
    {
        return $user->id === $item->user_id;
    }
}
