<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['event_type_id', 'what', 'all_day', 'start', 'end', 'repeat', 'repeat_every', 'repeat_end', 'where', 'visibility', 'description'];
    protected $dates = ['start', 'end', 'repeat_end'];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class)->withPivot(['is_owner']);
    }

    public function isOwner(User $user)
    {
        $owner = $this->user()->wherePivot('is_owner', 'Yes')->first();
        if($owner) {
            return $user->id == $owner->id;
        }
        return false;
    }}
