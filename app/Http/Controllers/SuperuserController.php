<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bundle;
use App\Models\JadwalEvent;
use App\Models\JadwalLatihan;
use App\Models\JadwalRapat;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class SuperuserController extends Controller
{
    // ====== Dashboard Superuser ======
    public function index()
    {
        if (auth()->user()->role === 'superuser') {
            return view('superuser.dashboard');
        }
        return redirect('/')->with('error', 'Unauthorized access');
    }

    // ====== Lihat Halaman Settings (Opsional) ======
    public function showSettings()
    {
        return view('superuser.settings');
    }

    // ====== Lihat Data Anggota ======
    public function indexAnggota()
    {
        try {
            $members = User::where('role', 'anggota')->with('biodata')->get();
            if (!view()->exists('superuser.kelola-anggota.index')) {
                Log::error('View superuser.kelola-anggota.index not found');
                abort(404, 'Halaman Lihat Data Anggota tidak ditemukan');
            }
            return view('superuser.kelola-anggota.index', compact('members'));
        } catch (\Exception $e) {
            Log::error('Error rendering indexAnggota view: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat Data Anggota');
        }
    }

    // ====== CRUD Anggota ======
    public function createAnggota()
    {
        return view('superuser.kelola-anggota.create-anggota');
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
        ]);

        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function editAnggota($id)
    {
        $members = User::where('role', 'anggota')->findOrFail($id);
        return view('superuser.kelola-anggota.edit-anggota', compact('anggota'));
    }

    public function updateAnggota(Request $request, $id)
    {
        $members = User::where('role', 'anggota')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $members->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $members->name  = $request->name;
        $members->email = $request->email;

        if ($request->filled('password')) {
            $members->password = Hash::make($request->password);
        }

        $members->save();

        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroyAnggota($id)
    {
        $members = User::where('role', 'anggota')->findOrFail($id);
        $members->delete();

        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    // ====== Password Anggota ======
    public function editPasswordAnggota($id)
    {
        $members = User::where('role', 'anggota')->findOrFail($id);
        return view('superuser.kelola-anggota.edit-password-anggota', compact('anggota'));
    }

    public function updatePasswordAnggota(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $anggota = User::where('role', 'anggota')->findOrFail($id);
        $anggota->password = Hash::make($request->password);
        $anggota->save();

        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Password anggota berhasil diperbarui.');
    }

    // ====== Search Anggota ======
    public function searchAnggota(Request $request)
    {
        $keyword = $request->keyword;
        $members = User::where('role', 'anggota')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                      ->orWhere('email', 'like', "%$keyword%")
                      ->orWhereHas('biodata', function ($query) use ($keyword) {
                          $query->where('nama_lengkap', 'like', "%$keyword%")
                                ->orWhere('nim', 'like', "%$keyword%");
                      });
            })
            ->with('biodata')
            ->get();

        return view('superuser.kelola-anggota.index', compact('members'));
    }

    // ====== Export Anggota PDF ======
    public function exportAnggota()
    {
        $members = User::where('role', 'anggota')->with('biodata')->get();
        $pdf = Pdf::loadView('superuser.kelola-anggota.pdf-export-anggota', compact('members'));
        return $pdf->download('data-anggota.pdf');
    }

    public function kelolaPasswordAnggota()
    {
        $members = User::where('role', 'anggota')->get();
        return view('superuser.kelola-password', compact('members'));
    }

    // ====== Kelola Bundle ======
    public function kelolaBundle()
    {
        $bundles = Bundle::all();
        return view('superuser.kelola-bundle.index', compact('bundles'));
    }

    public function createBundle()
    {
        return view('superuser.kelola-bundle.create');
    }

    public function storeBundle(Request $request)
    {
        $request->validate([
            'nama_bundle' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'jumlah_item' => 'required|integer|min:1',
        ]);

        Bundle::create($request->all());

        return redirect()->route('superuser.kelola-bundle.index')->with('success', 'Bundle berhasil ditambahkan.');
    }

    public function editBundle($id)
    {
        $bundle = Bundle::findOrFail($id);
        return view('superuser.kelola-bundle.edit', compact('bundle'));
    }

    public function updateBundle(Request $request, $id)
    {
        $request->validate([
            'nama_bundle' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'jumlah_item' => 'required|integer|min:1',
        ]);

        $bundle = Bundle::findOrFail($id);
        $bundle->update($request->all());

        return redirect()->route('superuser.kelola-bundle.index')->with('success', 'Bundle berhasil diperbarui.');
    }

    public function destroyBundle($id)
    {
        $bundle = Bundle::findOrFail($id);
        $bundle->delete();

        return redirect()->route('superuser.kelola-bundle.index')->with('success', 'Bundle berhasil dihapus.');
    }

    // ====== Kelola Jadwal Event ======
    public function kelolaJadwalEvent()
    {
        $jadwalEvents = JadwalEvent::all();
        return view('superuser.kelola-jadwal.event.index', compact('jadwalEvents'));
    }

    public function createJadwalEvent()
    {
        return view('superuser.kelola-jadwal.event.create');
    }

    public function storeJadwalEvent(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'tanggal'     => 'required|date',
            'waktu'       => 'nullable|string',
            'tempat'      => 'nullable|string',
        ]);

        JadwalEvent::create([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'tanggal'     => $request->tanggal,
            'waktu'       => $request->waktu,
            'tempat'      => $request->tempat,
        ]);

        return redirect()->route('superuser.jadwal.event.index')->with('success', 'Jadwal event berhasil ditambahkan.');
    }

    public function editJadwalEvent($id)
    {
        $jadwalEvent = JadwalEvent::findOrFail($id);
        return view('superuser.kelola-jadwal.event.edit', compact('jadwalEvent'));
    }

    public function updateJadwalEvent(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'tanggal'     => 'required|date',
            'waktu'       => 'nullable|string',
            'tempat'      => 'nullable|string',
        ]);

        $jadwalEvent = JadwalEvent::findOrFail($id);
        $jadwalEvent->update([
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'tanggal'     => $request->tanggal,
            'waktu'       => $request->waktu,
            'tempat'      => $request->tempat,
        ]);

        return redirect()->route('superuser.jadwal.event.index')->with('success', 'Jadwal event berhasil diperbarui.');
    }

    public function destroyJadwalEvent($id)
    {
        $jadwalEvent = JadwalEvent::findOrFail($id);
        $jadwalEvent->delete();

        return redirect()->route('superuser.jadwal.event.index')->with('success', 'Jadwal event berhasil dihapus.');
    }

    // ====== Kelola Jadwal Latihan ======
    public function kelolaJadwalLatihan()
    {
        $jadwalLatihans = JadwalLatihan::all();
        return view('superuser.kelola-jadwal.latihan.index', compact('jadwalLatihans'));
    }

    public function createJadwalLatihan()
    {
        return view('superuser.kelola-jadwal.latihan.create');
    }

    public function storeJadwalLatihan(Request $request)
    {
        $request->validate([
            'kegiatan'       => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'nullable|string',
            'waktu_selesai'  => 'nullable|string',
            'tempat'         => 'nullable|string',
            'catatan'        => 'nullable|string',
        ]);

        JadwalLatihan::create([
            'kegiatan'       => $request->kegiatan,
            'tanggal'        => $request->tanggal,
            'waktu_mulai'    => $request->waktu_mulai,
            'waktu_selesai'  => $request->waktu_selesai,
            'tempat'         => $request->tempat,
            'catatan'        => $request->catatan,
        ]);

        return redirect()->route('superuser.jadwal.latihan.index')->with('success', 'Jadwal latihan berhasil ditambahkan.');
    }

    public function editJadwalLatihan($id)
    {
        $jadwalLatihan = JadwalLatihan::findOrFail($id);
        return view('superuser.kelola-jadwal.latihan.edit', compact('jadwalLatihan'));
    }

    public function updateJadwalLatihan(Request $request, $id)
    {
        $request->validate([
            'kegiatan'       => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'nullable|string',
            'waktu_selesai'  => 'nullable|string',
            'tempat'         => 'nullable|string',
            'catatan'        => 'nullable|string',
        ]);

        $jadwalLatihan = JadwalLatihan::findOrFail($id);
        $jadwalLatihan->update([
            'kegiatan'       => $request->kegiatan,
            'tanggal'        => $request->tanggal,
            'waktu_mulai'    => $request->waktu_mulai,
            'waktu_selesai'  => $request->waktu_selesai,
            'tempat'         => $request->tempat,
            'catatan'        => $request->catatan,
        ]);

        return redirect()->route('superuser.jadwal.latihan.index')->with('success', 'Jadwal latihan berhasil diperbarui.');
    }

    public function destroyJadwalLatihan($id)
    {
        $jadwalLatihan = JadwalLatihan::findOrFail($id);
        $jadwalLatihan->delete();

        return redirect()->route('superuser.jadwal.latihan.index')->with('success', 'Jadwal latihan berhasil dihapus.');
    }

    // ====== Kelola Jadwal Rapat ======
    public function kelolaJadwalRapat()
    {
        $jadwalRapats = JadwalRapat::all();
        return view('superuser.kelola-jadwal.rapat.index', compact('jadwalRapats'));
    }

    public function createJadwalRapat()
    {
        return view('superuser.kelola-jadwal.rapat.create');
    }

    public function storeJadwalRapat(Request $request)
    {
        $request->validate([
            'agenda'      => 'required|string|max:255',
            'tanggal'     => 'required|date',
            'waktu'       => 'nullable|string',
            'tempat'      => 'nullable|string',
            'notulen'     => 'nullable|string',
        ]);

        JadwalRapat::create([
            'agenda'      => $request->agenda,
            'tanggal'     => $request->tanggal,
            'waktu'       => $request->waktu,
            'tempat'      => $request->tempat,
            'notulen'     => $request->notulen,
        ]);

        return redirect()->route('superuser.jadwal.rapat.index')->with('success', 'Jadwal rapat berhasil ditambahkan.');
    }

    public function editJadwalRapat($id)
    {
        $jadwalRapat = JadwalRapat::findOrFail($id);
        return view('superuser.kelola-jadwal.rapat.edit', compact('jadwalRapat'));
    }

    public function updateJadwalRapat(Request $request, $id)
    {
        $request->validate([
            'agenda'      => 'required|string|max:255',
            'tanggal'     => 'required|date',
            'waktu'       => 'nullable|string',
            'tempat'      => 'nullable|string',
            'notulen'     => 'nullable|string',
        ]);

        $jadwalRapat = JadwalRapat::findOrFail($id);
        $jadwalRapat->update([
            'agenda'      => $request->agenda,
            'tanggal'     => $request->tanggal,
            'waktu'       => $request->waktu,
            'tempat'      => $request->tempat,
            'notulen'     => $request->notulen,
        ]);

        return redirect()->route('superuser.jadwal.rapat.index')->with('success', 'Jadwal rapat berhasil diperbarui.');
    }

    public function destroyJadwalRapat($id)
    {
        $jadwalRapat = JadwalRapat::findOrFail($id);
        $jadwalRapat->delete();

        return redirect()->route('superuser.jadwal.rapat.index')->with('success', 'Jadwal rapat berhasil dihapus.');
    }

    // ====== Fitur-Fitur Lain ======
    public function kelolaPassword()
    {
        return view('superuser.kelola-anggota.password');
    }

    public function kelolaPaket()
    {
        return view('superuser.kelola-paket');
    }
}