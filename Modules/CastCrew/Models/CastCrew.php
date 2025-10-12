<?php

namespace Modules\CastCrew\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use  Modules\Entertainment\Models\EntertainmentTalentMapping;

class CastCrew extends BaseModel
{
    use SoftDeletes;

     protected $table = 'cast_crew';

     protected $fillable = ['name', 'type','file_url','tmdb_id','bio','place_of_birth','dob','designation'];


     public function entertainmentTalentMappings()
     {
         return $this->hasMany(EntertainmentTalentMapping::class,'talent_id','id');
     }
 

     protected static function boot()
     {
         parent::boot();
 
         static::deleting(function ($castcrew) {
 
             if ($castcrew->isForceDeleting()) {
 
                 $castcrew->entertainmentTalentMappings()->forcedelete();
 
             } else {
                 $castcrew->entertainmentTalentMappings()->delete();
              }
 
         });
 
         static::restoring(function ($castcrew) {
 
             $castcrew->entertainmentTalentMappings()->withTrashed()->restore();
             
         });
     }
 
    
}
