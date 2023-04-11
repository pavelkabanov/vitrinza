<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'name' => $user->getNameOrUsername(),
            //'avatar' => $user->avatar,
            'avatar' => $user->getAvatarUrl(),
        ];
    }
}