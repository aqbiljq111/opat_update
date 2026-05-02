<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'content', 'date', 'time', 'location', 
        'dresscode', 'category', 'created_by',
    ];

    // Accessor untuk badge "Terbaru!" (misal: jika dibuat dalam 3 hari terakhir)
    public function getIsNewAttribute()
    {
        return $this->created_at >= now()->subDays(3);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
