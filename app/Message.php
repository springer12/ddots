<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Sortable;

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('messages.updated_at');
    }

    public static function getValidationRules()
    {
        return [
            'text' => 'required|max:3000',
        ];
    }
}
