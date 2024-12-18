<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Define the table name (if different from the default)
    protected $table = 'products';

    // Fillable attributes (the ones you want to allow mass assignment for)
    protected $fillable = [
        'name', 'description', 'price', 'quantity', 'category'
    ];

    // Relationship: A product can have many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship: A product can have many orders through order items
    public function orders()
    {
        return $this->hasManyThrough(Order::class, OrderItem::class);
    }

    // Relationship: A product can have many favorites
    public function favoritedBy()
    {
        return $this->hasMany(Favorite::class); // Each product can have many favorites
    }

    // Relationship: A product can have many cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class); // Each product can appear in many cart items
    }

    // You can also define a method to get the count of cart items for a product
    public function cartItemsCount()
    {
        return $this->cartItems()->count(); // Get the number of times this product is in the cart
    }

    // You can also define a method to get the count of favorites for a product
    public function favoritesCount()
    {
        return $this->favoritedBy()->count(); // Get the number of users who have favorited this product
    }
}

