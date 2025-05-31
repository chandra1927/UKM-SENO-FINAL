<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Biodata;

class BiodataRequired
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'anggota') {
            $biodata = Biodata::where('user_id', auth()->user()->id)->first();
            if (!$biodata && $request->route()->getName() !== 'anggota.biodata.create' && $request->route()->getName() !== 'anggota.biodata.store') {
                return redirect()->route('anggota.biodata.create')->with('warning', 'Silakan lengkapi biodata Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}