<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function categoryable()
    {
        return $this->morphTo();
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    
    public function isHasSubcategories()
    {
        return (bool) $this->subcategories->count();
    }

    public static function mainCategories()
    {
        return static::where('parent_id', null)->get();
    }
}
