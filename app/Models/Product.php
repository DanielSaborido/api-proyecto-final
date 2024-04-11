<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'availability', 'category_id', 'image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function commentsAndRatings()
    {
        return $this->hasMany(CommentAndRating::class);
    }
}
