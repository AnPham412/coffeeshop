<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'status',
        'total_price'
    ];

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    public function feedbacks() {
        return $this->hasMany(Fback::class);
    }

    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class);
    }
}