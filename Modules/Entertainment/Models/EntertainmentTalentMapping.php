<?php

namespace Modules\Entertainment\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\CastCrew\Models\CastCrew;

class EntertainmentTalentMapping extends BaseModel
{
    use SoftDeletes;

    protected $table = 'entertainment_talent_mapping';

    protected $fillable = [
     
        'entertainment_id',
        'talent_id',
      
    ];


    public function talentprofile()
    {
        return $this->belongsTo(CastCrew::class,'talent_id');
    }



  
    
  
}
