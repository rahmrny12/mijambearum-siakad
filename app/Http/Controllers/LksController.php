<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Lks;
use App\Siswa;
use Illuminate\Http\Request;

class LksController extends Controller
{
    public function kelas_siswa()
    {
        $kelas = Kelas::get();

        return view('admin.lks.index', compact('kelas'));
    }

    public function kelas_siswa_show($id)
    {
        $siswa = Siswa::where('kelas_id', $id)->get();

        return view('admin.lks.show', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required'
        ]);

        Lks::create([
            'siswa_id' => $request->siswa_id,
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);

        return redirect()->back()->with('success', 'Pembelian LKS Berhasil');
    }

    public function show($id)
    {
        $siswa = Siswa::find($id);
        $lks = Lks::where('siswa_id', $id)->orderByDesc('created_at')->get();

        return view('admin.lks.riwayat', compact('siswa', 'lks'));
    }
}
