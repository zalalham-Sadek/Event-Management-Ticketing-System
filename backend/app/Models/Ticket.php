<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'type',
        'price',
        'quantity',
        'sold',
    ];

    protected $appends = ['remaining'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }


    public function getRemainingAttribute()
    {
        return $this->quantity - $this->sold;
    }
}
