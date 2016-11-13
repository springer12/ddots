<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @property integer $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $owner_id
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $sender
 * @property-read \App\User $receiver
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereSenderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereReceiverId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereOwnerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message latest()
 * @mixin \Eloquent
 */
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

    public function getSenderName()
    {
        return $this->sender->hasRole(\App\User::ROLE_ADMIN)?'admin':$this->sender->name;
    }
}
