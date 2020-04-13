<?php

namespace App\Subscriptions;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'subscription_id', 'user_id', 'remote_transaction_id', 
        'card_last_digits', 'amount', 'currency', 'status', 
    ];
}