<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'sender',
        'receiver',
        'amount',
        'source_currency',
        'target_currency',
        'exchange_rate',
        'status'
    ];
}
