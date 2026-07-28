<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $guarded = [];
    
    protected static function booted():void
    {
        static::creating(function(Ticket $ticket){
            $ticket->uuid ??= (string) \Illuminate\Support\Str::uuid();
            $ticket->tracking_code ??= 'Tick-' . strtoupper(\Illuminate\Support\Str::random(6));
        }); 
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
