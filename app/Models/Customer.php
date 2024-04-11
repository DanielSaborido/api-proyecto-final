<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['profile_image', 'name', 'email', 'address', 'phone_number'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function commentsAndRatings()
    {
        return $this->hasMany(CommentAndRating::class);
    }
}
