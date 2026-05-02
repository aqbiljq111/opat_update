<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::orderBy('date', 'desc');

        // Filter by Search (Title/Content)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by Month
        if ($request->filled('month') && $request->month != 'all') {
            $query->whereMonth('date', $request->month);
        }

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Filter by Location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $announcements = $query->get();

        if ($request->ajax()) {
            return view('dashboard.partials.list', compact('announcements'))->render();
        }

        return view('dashboard.index', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'category' => 'required|in:mingguan,bulanan,tahunan,Mingguan,Bulanan,Tahunan'
        ]);

        $data = $request->all();
        // Normalize to lowercase to match typical DB values and handle Indonesian names
        $data['category'] = strtolower($data['category']);
        $data['created_by'] = Auth::id();

        Announcement::create($data);

        return back()->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|string|max:255',
            'category' => 'required|in:mingguan,bulanan,tahunan,Mingguan,Bulanan,Tahunan'
        ]);

        $announcement = Announcement::findOrFail($id);
        
        $data = $request->all();
        $data['category'] = strtolower($data['category']);
        
        $announcement->update($data);

        return back()->with('success', 'Pengumuman berhasil diupdate!');
    }

    public function destroyAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}