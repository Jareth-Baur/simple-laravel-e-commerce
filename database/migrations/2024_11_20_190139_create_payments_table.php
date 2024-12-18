<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
        public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Assuming you have an orders table
            $table->string('payment_method');
            $table->string('card_number')->nullable();
            $table->string('expiration_date')->nullable();
            $table->string('card_owner_name')->nullable();
            $table->string('cvv')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('paypal_preference_code')->nullable();
            $table->string('gcash_number')->nullable();
            $table->string('gcash_preference_code')->nullable();
            $table->string('cod_address')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
