<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem; // Import the CartItem model

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the CartItem model
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}