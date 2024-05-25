<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'card_number',
        'expiry_date',
        'cvv',
    ];

    protected $hidden = [
        'card_number',
        'cvv',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
