<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    private $table = "payment_methods";

    protected $fillable = [
        'name'
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}