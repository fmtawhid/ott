<?php

namespace Modules\Subscriptions\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionTransactions extends BaseModel
{
    use HasFactory;

    protected $table = 'subscriptions_transactions';

    protected $fillable = ['subscriptions_id', 'user_id', 'amount','tax_data', 'payment_type', 'payment_status', 'transaction_id',  'other_transactions_details'];
    
      protected $casts = [
        'subscriptions_id' => 'integer',
        'user_id' => 'integer',
        'amount' => 'integer',
    ];

    protected static function newFactory()
    {
        return \Modules\Subscriptions\Database\factories\SubscriptionTransactionsFactory::new();
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscriptions_id', 'id');
    }
}
