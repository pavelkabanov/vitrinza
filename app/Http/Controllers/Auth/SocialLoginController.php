<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['social', 'guest']);
    }

    public function redirect($service, Request $request)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service, Request $request)
    {
        $serviceUser = Socialite::driver($service)->user();
        //dd($serviceUser);
        $user = $this->getExistingUser($serviceUser, $service);

        if (!$user) {
            $user = User::create([
                'name' => $serviceUser->getName(),
                'email' => $serviceUser->getEmail(),
                'avatar' => $serviceUser->getAvatar(),
                'active' => true
            ]);
        }
        else {
            $user->name = $serviceUser->getName();
            $user->avatar = $serviceUser->getAvatar();

            $user->save();
        }

        //$img = Image::make($serviceUser->getAvatar());
        //$ext = $img->guessClientExtension();
        // if($serviceUser->getAvatar()) {
        //     if($user->avatar) {
        //         Storage::delete('avatars/' . $user->avatar);
        //     }
        //     $ext = $serviceUser->getAvatar()->guessClientExtension();
        //     $imgName = $user->id . uniqid('-', true) . '.' . $ext;
        //     //$img->save(storage_path() . '/avatars' . '/' . $imgName);
        //     copy($serviceUser->getAvatar(), storage_path() . '/avatars' . '/' . $imgName);
        //     $user->avatar = $imgName;
        //     $user->save();
        // }

        if ($this->needsToCreateSocial($user, $service)) {
            $user->social()->create([
                'social_id' => $serviceUser->getId(),
                'service' => $service,
            ]);
        }

        Auth::login($user, true);

        //return redirect()->intended();
        return redirect()->to('/home');
    }

    protected function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    protected function getExistingUser($serviceUser, $service)
    {
        return User::where('email', $serviceUser->getEmail())->orWhereHas('social', function ($q) use ($serviceUser, $service) {
            $q->where('social_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}
