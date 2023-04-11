<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PivotOrderableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use Sluggable, SoftDeletes, PivotOrderableTrait;

    protected $fillable = [
        'name', 'description', 'image', 'link', 'slug'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likeable');
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains($user);
    }

    public function favorites()
    {
        return $this->morphToMany(User::class, 'favoriteable');
    }

    public function favoritedBy(User $user)
    {
        return $this->favorites->contains($user);
    }

    public function getHost()
    {
        if($this->link) {
            if((mb_substr($this->link, 0, 5) !== 'http:') and (mb_substr($this->link, 0, 6) !== 'https:')) return 'http://' . $this->link;
            else return $this->link;
        }
    }

    public function partner()
    {
        if($this->link) {
            $host_partials = explode(".", $this->link);
            $host_name = $host_partials[count($host_partials)-2];
            $host = $this->link;
            if(mb_substr($host, 0, 5) === 'http:') $host = 'http://'.$host;
            else if(mb_substr($host, 0, 6) === 'https:') $host = 'https://'.$host;
            else $host = 'http://'.$host;

            if(config("partners.{$host_name}", null)) {
                if(mb_strpos($this->link, '/?')) {
                    return $host.'&'.config("partners.{$host_name}");
                }
                else if(mb_substr($this->link, -1) === '/') {
                    return $host.'?'.config("partners.{$host_name}");
                }
                else {
                    return $host.'/?'.config("partners.{$host_name}");
                }
            }
            else return null;
        }
    }

}
