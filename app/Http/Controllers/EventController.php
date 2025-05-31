<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Mengambil semua event dari database
        $events = Event::all();
        return view('anggota.jadwal.event', compact('events'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string|max:500',
        ]);

        // Menyimpan event baru
        Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        // Redirect kembali ke halaman event
        return redirect()->route('anggota.jadwal.event')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Mencari event berdasarkan ID
        $event = Event::all();
        return view('anggota.jadwal.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string|max:500',
        ]);

        // Mencari event berdasarkan ID
        $event = Event::findOrFail($id);
        $event->update([
            'name' => $request->name,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        // Redirect kembali ke halaman event
        return redirect()->route('anggota.jadwal.event')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Mencari event berdasarkan ID dan menghapusnya
        $event = Event::findOrFail($id);
        $event->delete();

        // Redirect kembali ke halaman event
        return redirect()->route('anggota.jadwal.event')->with('success', 'Event berhasil dihapus!');
    }
}
