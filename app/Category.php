<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name','parent_id', 'slug']; 
    public function parent()
    {
        return $this->belongsto(Category::class);
    }

    public function scopeGetParent($query)
    {
        return $query->wherenull('parent_id');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    //ACCESSOR
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function product()//relasi dengan tabel product
    {
        // jenis relasi one to many, category bisa digunakan oleh banyak product
        return $this->hasMany(Product::class);  
    }
    
}

