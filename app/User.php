<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'avatar', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public static function byEmail($email)
    {
        return static::where('email', $email);
    }

    public static function byIdOrUsername($user)
    {
        if(is_numeric($user)) {
            return static::where('id', $user)->firstOrFail();
        }
        else {
            return static::where('username', $user)->firstOrFail();
        }
    }

    public function getAvatarUrl($size = 100)
    {
        if ($this->avatar)
        {
            return $this->avatar;
        }
        else {
            return "https://www.gravatar.com/avatar/" . md5($this->email) . "?d=mm&s={$size}";
        }
    }

    public function social()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function hasSocialLinked($service)
    {
        return (bool) $this->social->where('service', $service)->count();
    }

    public function activationToken()
    {
        return $this->hasOne(ActivationToken::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function getNameOrUsername() {
        if($this->name) {
            return $this->name;
        }
        else if($this->username) {
            return $this->username;
        }
        else {
            return '';
        }
    }

    public function favoriteItems()
    {
        return $this->morphedByMany(Item::class, 'favoriteable')
            ->withPivot(['created_at'])
            ->orderByPivot('created_at', 'desc');
    }

    public function likeItems()
    {
        return $this->morphedByMany(Item::class, 'likeable')
            ->withPivot(['created_at'])
            ->orderByPivot('created_at', 'desc');
    }
}
