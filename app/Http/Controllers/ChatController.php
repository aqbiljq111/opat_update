<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::with(['sender', 'replies'])
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('message', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->get();

        if ($request->ajax()) {
            return view('chat.partials.list', compact('messages'))->render();
        }

        return view('chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'message' => 'required'
        ]);
        
        $msg = Message::create([
            'sender_id' => Auth::id(),
            'title' => $request->title,
            'message' => $request->message
        ]);

        MessageLog::create([
            'user_id' => Auth::id(),
            'message_id' => $msg->id,
            'title' => $request->title,
            'message' => $request->message,
            'action' => 'created'
        ]);

        return back()->with('success', 'Pertanyaan berhasil diposting');
    }

    public function show($id)
    {
        $message = Message::with(['sender', 'nestedReplies'])->findOrFail($id);
        
        // Ensure we are viewing a top-level thread
        if ($message->parent_id !== null) {
            return redirect()->route('chat.show', $message->parent_id);
        }

        return view('chat.show', compact('message'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['message' => 'required']);
        
        $parent = Message::findOrFail($id);

        // Siswa hanya bisa reply dari jawaban guru (jika parent adalah reply dari guru)
        // Atau jika ini adalah reply pertama ke thread (hanya guru yang boleh?)
        // User request: "guru-guru menjawab dan siswa Hanya bisa replay dari jawaban guru"
        
        $user = Auth::user();
        
        // Logic check based on user requirements:
        // 1. If parent is a Thread (parent_id is null): Only Guru can reply? 
        //    (User said: "guru-guru menjawab" below the student question)
        // 2. If parent is a Reply: Anyone can reply? 
        //    (User said: "siswa Hanya bisa replay dari jawaban guru")

        if ($parent->parent_id === null) {
            // Replying to a thread: Only Guru/Admin
            if ($user->role !== 'guru' && $user->role !== 'admin') {
                return back()->with('error', 'Hanya guru yang dapat menjawab pertanyaan pertama kali.');
            }
        }
        // If not replying to a thread (meaning it's a nested reply), anyone can reply to it.

        $reply = Message::create([
            'sender_id' => $user->id,
            'parent_id' => $id,
            'message' => $request->message
        ]);

        MessageLog::create([
            'user_id' => $user->id,
            'message_id' => $reply->id,
            'parent_id' => $id,
            'message' => $request->message,
            'action' => 'replied'
        ]);

        return back()->with('success', 'Balasan berhasil dikirim');
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $user = Auth::user();

        // Only owner can edit. Admin/Guru can delete but not edit others' posts? 
        // Usually, only the sender can edit. Let's stick to that.
        if ($message->sender_id !== $user->id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengedit pesan ini.');
        }

        $rules = [
            'message' => 'required'
        ];

        if ($message->parent_id === null) {
            $rules['title'] = 'required|max:255';
        }

        $request->validate($rules);

        $message->update([
            'title' => $request->title ?? $message->title,
            'message' => $request->message
        ]);

        MessageLog::create([
            'user_id' => $user->id,
            'message_id' => $message->id,
            'parent_id' => $message->parent_id,
            'title' => $request->title ?? $message->title,
            'message' => $request->message,
            'action' => 'updated'
        ]);

        return back()->with('success', 'Pesan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $user = Auth::user();

        // Admin/Guru can delete any message. Siswa can only delete their own.
        if ($user->role !== 'admin' && $user->role !== 'guru' && $message->sender_id !== $user->id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus pesan ini.');
        }

        $isThread = $message->parent_id === null;

        MessageLog::create([
            'user_id' => $user->id,
            'message_id' => $message->id,
            'parent_id' => $message->parent_id,
            'title' => $message->title,
            'message' => $message->message,
            'action' => 'deleted'
        ]);

        $message->delete();

        if ($isThread) {
            return redirect()->route('chat')->with('success', 'Pertanyaan beserta seluruh balasannya berhasil dihapus.');
        }

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}