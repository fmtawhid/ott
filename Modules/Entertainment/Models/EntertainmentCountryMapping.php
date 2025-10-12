<?php

namespace Modules\Entertainment\Models;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\World\Models\Country;

class EntertainmentCountryMapping extends BaseModel
{
    use SoftDeletes;

    protected $table = 'entertainment_country_mapping';

    protected $fillable = [

        'entertainment_id',
        'country_id',

    ];


    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }



}

