<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    private $table = "carts";

    public function user() {
        return $this->hasOne(User::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function cartProducts() {
        return $this->hasMany(CartProduct::class);
    }
}