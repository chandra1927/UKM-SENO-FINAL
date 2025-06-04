<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Biodata;
use App\Models\Bundle;
use App\Models\JadwalEvent;
use App\Models\JadwalLatihan;
use App\Models\JadwalRapat;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SuperuserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:superuser');
    }

    public function index()
    {
        return view('superuser.dashboard');
    }

    public function showSettings()
    {
        return view('superuser.settings');
    }

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

    public function createAnggota()
    {
        return view('superuser.kelola-anggota.create-anggota');
    }

    public function storeAnggota(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
        ]);

        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function editAnggota(User $member)
    {
        if (!$member || $member->role !== 'anggota') {
            abort(404, 'Anggota tidak ditemukan');
        }
        $member->load('biodata');
        return view('superuser.kelola-anggota.edit', compact('member'));
    }

    public function updateAnggota(Request $request, User $member)
    {
        if (!$member || $member->role !== 'anggota') {
            abort(404, 'Anggota tidak ditemukan');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:6|confirmed',
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:biodatas,nim,' . ($member->biodata ? $member->biodata->id : ''),
            'divisi' => 'required|string|max:100',
            'angkatan' => 'required|string|max:10',
            'posisi' => 'required|string|max:100',
        ]);

        $updated = $member->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $member->password,
        ]);

        if ($updated) {
            if ($member->biodata) {
                $member->biodata->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'nim' => $request->nim,
                    'divisi' => $request->divisi,
                    'angkatan' => $request->angkatan,
                    'posisi' => $request->posisi,
                ]);
            } else {
                Biodata::create([
                    'user_id' => $member->id,
                    'nama_lengkap' => $request->nama_lengkap,
                    'nim' => $request->nim,
                    'divisi' => $request->divisi,
                    'angkatan' => $request->angkatan,
                    'posisi' => $request->posisi,
                ]);
            }
        }

        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroyAnggota(User $member)
    {
        if (!$member || $member->role !== 'anggota') {
            abort(404, 'Anggota tidak ditemukan');
        }
        $member->delete();
        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function editPasswordAnggota(User $member)
    {
        if (!$member || $member->role !== 'anggota') {
            abort(404, 'Anggota tidak ditemukan');
        }
        return view('superuser.kelola-anggota.edit-password-anggota', compact('member'));
    }

    public function updatePasswordAnggota(Request $request, User $member)
    {
        if (!$member || $member->role !== 'anggota') {
            abort(404, 'Anggota tidak ditemukan');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $member->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('superuser.kelola-anggota.index')->with('success', 'Password anggota berhasil diperbarui.');
    }

    public function kelolaPasswordAnggota()
    {
        try {
            $members = User::where('role', 'anggota')->get();
            if (!view()->exists('superuser.kelola-password')) {
                Log::error('View superuser.kelola-password not found');
                abort(404, 'Halaman Kelola Password Anggota tidak ditemukan');
            }
            return view('superuser.kelola-password', compact('members'));
        } catch (\Exception $e) {
            Log::error('Error rendering kelolaPasswordAnggota view: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat halaman Kelola Password Anggota');
        }
    }

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

    public function exportAnggota()
    {
        $members = User::where('role', 'anggota')->with('biodata')->get();
        $pdf = Pdf::loadView('superuser.kelola-anggota.pdf-export-anggota', compact('members'));
        return $pdf->download('data-anggota.pdf');
    }

    public function kelolaBundle()
    {
        $bundles = Bundle::all();
        return view('superuser.kelola-bundle.index', compact('bundles'));
    }

    public function createBundle()
    {
        $members = User::where('role', 'anggota')->get();
        return view('superuser.kelola-bundle.create', compact('members'));
    }

    public function storeBundle(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'isi_paket' => 'required|array|min:1',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'video' => 'nullable|file|mimes:mp4|max:20480',
        ]);

        $data = [
            'nama_paket' => $request->nama_paket,
            'isi_paket' => $request->isi_paket,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ];

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
            $data['video_path'] = $videoPath;
        }

        Bundle::create($data);

        return redirect()->route('superuser.kelola-bundle.index')->with('success', 'Bundle berhasil ditambahkan.');
    }

    public function editBundle($id)
    {
        $bundle = Bundle::findOrFail($id);
        $members = User::where('role', 'anggota')->get();
        return view('superuser.kelola-bundle.edit', compact('bundle', 'members'));
    }

    public function updateBundle(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'isi_paket' => 'required|array|min:1',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'video' => 'nullable|file|mimes:mp4|max:20480',
        ]);

        $bundle = Bundle::findOrFail($id);

        $data = [
            'nama_paket' => $request->nama_paket,
            'isi_paket' => $request->isi_paket,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ];

        if ($request->hasFile('video')) {
            if ($bundle->video_path && Storage::disk('public')->exists($bundle->video_path)) {
                Storage::disk('public')->delete($bundle->video_path);
            }
            $videoPath = $request->file('video')->store('videos', 'public');
            $data['video_path'] = $videoPath;
        }

        $bundle->update($data);

        return redirect()->route('superuser.kelola-bundle.index')->with('success', 'Bundle berhasil diperbarui.');
    }

    public function destroyBundle($id)
    {
        $bundle = Bundle::findOrFail($id);
        if ($bundle->video_path && Storage::disk('public')->exists($bundle->video_path)) {
            Storage::disk('public')->delete($bundle->video_path);
        }
        $bundle->delete();

        return redirect()->route('superuser.kelola-bundle.index')->with('success', 'Bundle berhasil dihapus.');
    }

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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|string',
            'tempat' => 'nullable|string',
        ]);

        JadwalEvent::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
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
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|string',
            'tempat' => 'nullable|string',
        ]);

        $jadwalEvent = JadwalEvent::findOrFail($id);
        $jadwalEvent->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
        ]);

        return redirect()->route('superuser.jadwal.event.index')->with('success', 'Jadwal event berhasil diperbarui.');
    }

    public function destroyJadwalEvent($id)
    {
        $jadwalEvent = JadwalEvent::findOrFail($id);
        $jadwalEvent->delete();

        return redirect()->route('superuser.jadwal.event.index')->with('success', 'Jadwal event berhasil dihapus.');
    }

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
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable|string',
            'waktu_selesai' => 'nullable|string',
            'tempat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        JadwalLatihan::create([
            'kegiatan' => $request->kegiatan,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tempat' => $request->tempat,
            'catatan' => $request->catatan,
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
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable|string',
            'waktu_selesai' => 'nullable|string',
            'tempat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $jadwalLatihan = JadwalLatihan::findOrFail($id);
        $jadwalLatihan->update([
            'kegiatan' => $request->kegiatan,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tempat' => $request->tempat,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('superuser.jadwal.latihan.index')->with('success', 'Jadwal latihan berhasil diperbarui.');
    }

    public function destroyJadwalLatihan($id)
    {
        $jadwalLatihan = JadwalLatihan::findOrFail($id);
        $jadwalLatihan->delete();

        return redirect()->route('superuser.jadwal.latihan.index')->with('success', 'Jadwal latihan berhasil dihapus.');
    }

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
            'agenda' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|string',
            'tempat' => 'nullable|string',
            'notulen' => 'nullable|string',
        ]);

        JadwalRapat::create([
            'agenda' => $request->agenda,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
            'notulen' => $request->notulen,
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
            'agenda' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'nullable|string',
            'tempat' => 'nullable|string',
            'notulen' => 'nullable|string',
        ]);

        $jadwalRapat = JadwalRapat::findOrFail($id);
        $jadwalRapat->update([
            'agenda' => $request->agenda,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
            'notulen' => $request->notulen,
        ]);

        return redirect()->route('superuser.jadwal.rapat.index')->with('success', 'Jadwal rapat berhasil diperbarui.');
    }

    public function destroyJadwalRapat($id)
    {
        $jadwalRapat = JadwalRapat::findOrFail($id);
        $jadwalRapat->delete();

        return redirect()->route('superuser.jadwal.rapat.index')->with('success', 'Jadwal rapat berhasil dihapus.');
    }

    public function kelolaPassword()
    {
        return view('superuser.kelola-anggota.password');
    }

    public function kelolaPaket()
    {
        return view('superuser.kelola-paket');
    }

    public function kelolaOrder()
    {
        try {
            $orders = Order::with(['user', 'bundle'])->latest()->get();
            if (!view()->exists('superuser.kelola-order.index')) {
                Log::error('View superuser.kelola-order.index not found');
                abort(404, 'Halaman Kelola Order tidak ditemukan');
            }
            return view('superuser.kelola-order.index', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error rendering kelolaOrder view: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat halaman Kelola Order');
        }
    }
}