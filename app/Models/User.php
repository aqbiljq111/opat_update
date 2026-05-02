<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $fillable = ['name', 'username', 'email', 'password', 'role', 'nip'];
    protected $hidden = ['password'];
    
    public $timestamps = true;

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
