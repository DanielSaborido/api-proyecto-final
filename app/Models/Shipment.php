<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ['order_id', 'shipping_date', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
