<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    /**
     * Define the relationship with the Order model.
     * An OrderItem belongs to an Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Define the relationship with the Product model.
     * An OrderItem belongs to a Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
}
