<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        'name'
    ];
    public $timestamps=false;

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}