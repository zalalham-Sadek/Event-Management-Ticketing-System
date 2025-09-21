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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getRemainingAttribute()
    {
        return $this->quantity - $this->sold;
    }

    /**
     * Check if the requested quantity is available
     */
    public function isAvailable($quantity)
    {
        return $this->remaining >= $quantity;
    }

    /**
     * Safely increment sold quantity
     */
    public function incrementSold($quantity)
    {
        if (!$this->isAvailable($quantity)) {
            throw new \Exception("Not enough tickets available. Available: {$this->remaining}, Requested: {$quantity}");
        }
        
        $this->increment('sold', $quantity);
        return $this->fresh();
    }

    /**
     * Safely decrement sold quantity
     */
    public function decrementSold($quantity)
    {
        $newSoldCount = max(0, $this->sold - $quantity);
        $this->update(['sold' => $newSoldCount]);
        return $this->fresh();
    }
}
