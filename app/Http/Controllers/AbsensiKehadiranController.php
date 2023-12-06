<?php

namespace App\Http\Controllers;

use App\AbsensiKehadiranGuru;
use App\AbsensiKehadiran;
use App\AturanJamSiswa;
use App\Guru;
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

    public function guru()
    {
        $absensi_kehadiran = AbsensiKehadiranGuru::get();
        // dd($absensi_kehadiran);
        
        return view('absensi_kehadiran.guru', compact('absensi_kehadiran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if ($type == 'siswa') {
            return view('absensi_kehadiran.absen', compact('type'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
        ]);
        
        $is_siswa = true;
        $user = Siswa::with('kelas')->where('rfid', $request->keyword)->first();
        // return response()->json(['tes' => 'tes']);
        if (!$user) {
            $is_siswa = false;
            $user = Guru::where('rfid', $request->keyword)->first();
        }

        if ($user) {
            $aturan_jam_siswa = AturanJamSiswa::where('status', 1)->first();

            $jam_sekarang = Carbon::now()->toTimeString();

            if ($is_siswa) {
                $existing_absen = AbsensiKehadiran::where(['id_siswa' => $user->id, 'tanggal' => Carbon::now()->format('Y-m-d')])->first();
            } else {
                $existing_absen = AbsensiKehadiranGuru::where(['id_guru' => $user->id, 'tanggal' => Carbon::now()->format('Y-m-d')])->first();
            }

            if ($existing_absen) {
                if ($existing_absen->jam_pulang) {
                    return response()->json(['success' => 'Absensi pulang sudah berhasil']);
                } else {
                    if ($aturan_jam_siswa->jam_pulang > $jam_sekarang) {
                        return response()->json(['warning' => 'Jam pulang belum tercapai']);
                    }
                    
                    $existing_absen->update([
                        'jam_pulang' => $jam_sekarang,
                    ]);
                    
                    return response()->json(['success' => 'Absensi pulang berhasil']);
                }
            }
            
            $jam_masuk = $aturan_jam_siswa->jam_masuk;
            $keterangan = 'Tepat Waktu';

            if ($jam_sekarang > $jam_masuk) {
                $keterangan = 'Terlambat';
            }
            
            if ($is_siswa) {
                AbsensiKehadiran::create([
                    'id_siswa' => $user->id,
                    'jam_masuk' => $jam_sekarang,
                    'jam_pulang' => null,
                    'status_masuk' => $keterangan,
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                ]);
            } else {
                AbsensiKehadiranGuru::create([
                    'id_guru' => $user->id,
                    'jam_masuk' => $jam_sekarang,
                    'jam_pulang' => null,
                    'status_masuk' => $keterangan,
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                ]);
            }

            return response()->json(['success' => 'Absensi masuk berhasil']);
        } else {
            return response()->json(['error' => 'Siswa tidak ditemukan']);
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
        $request->validate([
            'keyword' => 'required',
        ]);
        
        $user = Siswa::with('kelas')->where('rfid', $request->keyword)->first();
        if (!$user) {
            $user = Guru::where('rfid', $request->keyword)->first();
        }
        
        return response()->json($user);
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
