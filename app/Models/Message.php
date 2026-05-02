<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['sender_id', 'receiver_id', 'title', 'parent_id', 'message'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($message) {
            $message->replies()->each(function ($reply) {
                $reply->delete();
            });
        });
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    public function nestedReplies()
    {
        return $this->hasMany(Message::class, 'parent_id')->with(['sender', 'nestedReplies']);
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }
}