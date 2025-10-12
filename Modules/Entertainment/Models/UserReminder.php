<?php

namespace Modules\Entertainment\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReminder extends BaseModel
{
    use SoftDeletes;

    protected $table = 'user_reminder';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['entertainment_id','user_id','release_date','is_remind','profile_id'];
    
    public function entertainment()
    {
        return $this->hasOne(Entertainment::class, 'id', 'entertainment_id')->with('entertainmentGenerMappings','plan');
    }
}
