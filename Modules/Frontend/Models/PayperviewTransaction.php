<?php

namespace Modules\Frontend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Frontend\Database\factories\PayperviewTransactionFactory;

class PayperviewTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $table = 'payperviewstransactions';
    protected $fillable = [
        'user_id',
        'amount',
        'payment_type',
        'payment_status',
        'transaction_id',
        'pay_per_view_id',
    ];
    
}
