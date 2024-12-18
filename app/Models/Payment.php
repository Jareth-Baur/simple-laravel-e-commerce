<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Specify the table name (optional, Laravel will default to the plural form of the model name)
    protected $table = 'payments';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'order_id',
        'payment_method',
        'card_number',
        'expiration_date',
        'card_owner_name',
        'cvv',
        'paypal_email',
        'paypal_preference_code',
        'gcash_number',
        'gcash_preference_code',
        'cod_address',
    ];

    // If you want to define relationships, you can do so here
    // For example, if the Payment model belongs to an Order model
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
