<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageLogController extends Controller
{
    public function index()
    {
        $logs = \App\Models\MessageLog::with(['user'])->orderBy('created_at', 'desc')->paginate(20);
        return view('chat.history', compact('logs'));
    }
}
