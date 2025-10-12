<?php

namespace Modules\Subscriptions\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class PlanLimitation extends BaseModel
{

    use SoftDeletes;

    protected $table = 'planlimitation';

    protected $fillable = ['title','slug','description', 'status'];
    

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = slug_format(trim($value));

        if (empty($value)) {
            $this->attributes['slug'] = slug_format(trim($this->attributes['name']));
        }
    }



   
}
