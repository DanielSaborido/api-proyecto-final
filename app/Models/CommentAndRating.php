<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentAndRating extends Model
{
    protected $fillable = ['product_id', 'customer_id', 'title', 'comment', 'rating'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
