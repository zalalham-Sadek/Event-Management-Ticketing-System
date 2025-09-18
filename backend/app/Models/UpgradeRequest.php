<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpgradeRequest extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'user_id','organization_name','documents','status','rejection_reason'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
