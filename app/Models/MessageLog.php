<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    protected $fillable = ['user_id', 'message_id', 'parent_id', 'title', 'message', 'action'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parentMessage()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }
}
