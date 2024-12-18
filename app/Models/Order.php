<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Fillable attributes
    protected $fillable = [
        'user_id',
        'status',
        'total',
    ];

    /**
     * Relationship with OrderItem.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship with Payment.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relationship with User (assuming you have a User model).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
