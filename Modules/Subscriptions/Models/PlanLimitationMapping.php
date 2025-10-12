<?php

namespace Modules\Subscriptions\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PlanLimitationMapping extends Model
{
    use SoftDeletes;

    protected $table = 'planlimitation_mapping';

    protected $fillable = ['plan_id','limitation_slug', 'planlimitation_id','limitation_value','limit'];

    public function limitation_data()
    {
        return $this->belongsTo(PlanLimitation::class, 'planlimitation_id', 'id')->withTrashed();
    }


}
