<?php

namespace Modules\Entertainment\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Genres\Models\Genres;

class EntertainmentGenerMapping extends BaseModel
{
    use SoftDeletes;

    protected $table = 'entertainment_gener_mapping';

    protected $fillable = [

        'entertainment_id',
        'genre_id',

    ];


    public function genre()
    {
        return $this->belongsTo(Genres::class,'genre_id');
    }



}
