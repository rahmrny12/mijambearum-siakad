<?php

namespace App\Http\Controllers;

use App\Infaq;
use App\Kelas;
use App\Siswa;
use Illuminate\Http\Request;

class InfaqController extends Controller
{
    public function kelas_siswa()
    {
        $kelas = Kelas::get();

        return view('admin.infaq.index', compact('kelas'));
    }

    public function kelas_siswa_show($id)
    {
        $siswa = Siswa::where('kelas_id', $id)->get();

        return view('admin.infaq.show', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required'
        ]);

        Infaq::create([
            'siswa_id' => $request->siswa_id,
            'nominal' => $request->nominal
        ]);

        return redirect()->back()->with('success', 'Infaq Berhasil ditambahkan');
    }

    public function show($id)
    {
        $siswa = Siswa::find($id);
        $infaq = Infaq::where('siswa_id', $id)->orderByDesc('created_at')->get();

        return view('admin.infaq.riwayat', compact('siswa', 'infaq'));
    }
}
