<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','type', 'description', 'date', 'location', 'poster', 'user_id'
    ];

    // Organizer
public function user()
{
    return $this->belongsTo(User::class);
}


    // Attendees
    public function attendees() {
        return $this->belongsToMany(User::class, 'event_attendees');
    }
}
