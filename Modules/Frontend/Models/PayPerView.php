<?php

namespace Modules\Frontend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Entertainment\Models\Entertainment;
use Modules\Episode\Models\Episode;
use Modules\Frontend\Database\factories\PayPerViewFactory;
use Modules\Video\Models\Video;
use App\Models\User;

class PayPerView extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'pay_per_views';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id',
        'movie_id',
        'type',
        'price',
        'content_price',
        'discount_percentage',
        'tax_amount',
        'total_amount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'view_expiry_date',
        'access_duration',
        'available_for',
    ];

    // Define relationships, if needed
    
    protected static function newFactory(): PayPerViewFactory
    {
        //return PayPerViewFactory::new();
    }

    public function movie()
    {
        return $this->belongsTo(Entertainment::class, 'movie_id');
    }

      public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function episode()
    {
        return $this->belongsTo(Episode::class, 'movie_id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'movie_id');
    }

     public function PayperviewTransaction()
    {
        return $this->belongsTo(PayperviewTransaction::class, 'id','pay_per_view_id');
    }
}
