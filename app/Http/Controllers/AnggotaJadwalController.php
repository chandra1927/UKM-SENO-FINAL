<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\JadwalEvent;
use App\Models\JadwalLatihan;
use App\Models\JadwalRapat;

class AnggotaJadwalController extends Controller
{
    // Dashboard anggota
    public function index()
    {
        return view('anggota.dashboard');
    }

    // ================================
    // Fitur Jadwal Anggota
    // ================================

    public function event()
{
    $jadwalEvents = JadwalEvent::all();
    return view('anggota.event', compact('jadwalEvents'));
}

public function latihan()
{
    $jadwalLatihans = JadwalLatihan::all();
    return view('anggota.latihan', compact('jadwalLatihans'));
}

public function rapat()
{
    $jadwalRapats = JadwalRapat::all();
    return view('anggota.rapat', compact('jadwalRapats'));
}

    // ================================
    // CRUD Biodata
    // ================================

    public function createBiodata()
    {
        return view('anggota.biodata.create');
    }

    public function storeBiodata(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:biodatas',
            'divisi' => 'required|string|max:100',
            'angkatan' => 'required|string|max:10',
            'posisi' => 'required|string|max:100',
        ]);

        Biodata::create([
            'user_id' => auth()->id(),
            'nama_lengkap' => $request->nama_lengkap,
            'nim' => $request->nim,
            'divisi' => $request->divisi,
            'angkatan' => $request->angkatan,
            'posisi' => $request->posisi,
        ]);

        return redirect()->route('anggota.index')->with('success', 'Biodata berhasil disimpan');
    }

    public function editBiodata(Biodata $biodata)
    {
        if ($biodata->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        return view('anggota.biodata.edit', compact('biodata'));
    }

    public function updateBiodata(Request $request, Biodata $biodata)
    {
        if ($biodata->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:biodatas,nim,' . $biodata->id,
            'divisi' => 'required|string|max:100',
            'angkatan' => 'required|string|max:10',
            'posisi' => 'required|string|max:100',
        ]);

        $biodata->update($request->all());

        return redirect()->route('anggota.biodata.index')->with('success', 'Biodata berhasil diperbarui');
    }

    public function destroyBiodata(Biodata $biodata)
    {
        if ($biodata->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $biodata->delete();

        return redirect()->route('anggota.biodata.index')->with('success', 'Biodata berhasil dihapus');
    }

    public function indexBiodata()
    {
        $biodata = Biodata::where('user_id', auth()->id())->first();
        return view('anggota.biodata.index', compact('biodata'));
    }
}