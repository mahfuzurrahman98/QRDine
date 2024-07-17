<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;

    protected $fillable = [
        'stripe_id', 'session_payment_created',
        'session_id', 'session_payment_id',
        'customer_email', 'customer_name',
        'currency', 'amount',
    ];
}
