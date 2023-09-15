<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;

    protected $table = "cart_items";

    public function cart(): void
    {
        $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

}
