<?php

namespace App\Http\Controllers;

use App\AbsensiKehadiran;
use App\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiKehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $absensi_kehadiran = AbsensiKehadiran::get();
        
        return view('absensi_kehadiran.index', compact('absensi_kehadiran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if ($type == 'siswa') {
            return view('absensi_kehadiran.absen_siswa');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
        ]);
        
        $siswa = Siswa::with('kelas')->where('rfid', $request->keyword)->first();

        if ($siswa) {
            AbsensiKehadiran::create([
                'id_siswa' => $siswa->id,
                'jam_masuk' => Carbon::now()->toTimeString(),
                'jam_pulang' => null,
                'status_masuk' => 'Tepat Waktu',
                'tanggal' => Carbon::now()->format('Y-m-d'),
            ]);

            return redirect()->back()->with('success', 'Aktivitas berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AbsensiKehadiran  $absensiKehadiran
     * @return \Illuminate\Http\Response
     */
    public function show(AbsensiKehadiran $absensiKehadiran)
    {
    }

    public function cari_siswa(Request $request)
    {
        $siswa = Siswa::with('kelas')->where('rfid', $request->keyword)->first();
        return response()->json($siswa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AbsensiKehadiran  $absensiKehadiran
     * @return \Illuminate\Http\Response
     */
    public function edit(AbsensiKehadiran $absensiKehadiran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AbsensiKehadiran  $absensiKehadiran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AbsensiKehadiran $absensiKehadiran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AbsensiKehadiran  $absensiKehadiran
     * @return \Illuminate\Http\Response
     */
    public function destroy(AbsensiKehadiran $absensiKehadiran)
    {
        //
    }
}
