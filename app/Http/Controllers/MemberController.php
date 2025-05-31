<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;

class MemberController extends Controller
{

// Tampilkan semua biodata
public function indexBiodata()
{
    $biodatas = Biodata::all();
    return view('biodata.index', compact('biodatas'));
}

// Form tambah biodata
public function createBiodata()
{
    return view('biodata.create');
}

// Simpan biodata baru
public function storeBiodata(Request $request)
{
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'nim' => 'required|string|max:50|unique:biodatas',
        'divisi' => 'required|string|max:100',
        'angkatan' => 'required|string|max:10',
        'posisi' => 'required|string|max:100',
    ]);

    Biodata::create($request->all());
    return redirect()->route('member.biodata.index')->with('success', 'Data berhasil ditambahkan');
}

// Form edit biodata
public function editBiodata(Biodata $biodata)
{
    return view('biodata.edit', compact('biodata'));
}

// Update biodata
public function updateBiodata(Request $request, Biodata $biodata)
{
    $request->validate([
        'nama_lengkap' => 'required|string|max:255',
        'nim' => 'required|string|max:50|unique:biodatas,nim,' . $biodata->id,
        'divisi' => 'required|string|max:100',
        'angkatan' => 'required|string|max:10',
        'posisi' => 'required|string|max:100',
    ]);

    $biodata->update($request->all());
    return redirect()->route('member.biodata.index')->with('success', 'Data berhasil diperbarui');
}

// Hapus biodata
public function destroyBiodata(Biodata $biodata)
{
    $biodata->delete();
    return redirect()->route('member.biodata.index')->with('success', 'Data berhasil dihapus');
}
}