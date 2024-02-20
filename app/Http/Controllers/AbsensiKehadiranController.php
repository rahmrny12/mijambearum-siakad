<?php

namespace App\Http\Controllers;

use App\AbsensiKehadiranGuru;
use App\AbsensiKehadiran;
use App\AturanJamSiswa;
use App\Guru;
use App\Siswa;
use App\Kelas;
use Crypt;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiSiswaExport;
use App\Exports\AbsensiGuruExport;

class AbsensiKehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::OrderBy('nama_kelas', 'asc')->get();
        return view('absensi_kehadiran.index', compact('kelas'));
    }

    public function kelas($id)
    {
        $id = Crypt::decrypt($id);
        $absensi_kehadiran = AbsensiKehadiran::whereHas('siswa', function ($query) use ($id) {
            $query->where('kelas_id', $id);
        })->get();
        $kelas = Kelas::findorfail($id);
        return view('absensi_kehadiran.show', compact('absensi_kehadiran', 'kelas'));
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
        return view('absensi_kehadiran.absen', compact('type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
        ]);
        
        $is_siswa = true;
        $user = Siswa::with('kelas')->where('rfid', $request->keyword)->first();
        if (!$user) {
            $is_siswa = false;
            $user = Guru::where('rfid', $request->keyword)->first();
        }
        
        if ($user) {
            $aturan_jam_siswa = AturanJamSiswa::where('status', 1)->first();

            if (!$aturan_jam_siswa)
                return response()->json(['warning' => 'Tidak ada jam mengajar yang aktif']);

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

                    $existing_absen->refresh();

                    if ($is_siswa && $user->no_telp != 0) {
                        $formattedDate = Carbon::parse($existing_absen->tanggal)->locale('id')->isoFormat('D MMMM YYYY');

                        $client = new Client;
                        $request = $client->post('http://128.199.217.52/send-message', [
                            'form_params' => [
                                'message' => "INFO ABSENSI MIS JAMBE ARUM\n\nNAMA : {$user->nama_siswa}\nKELAS : {$user->kelas->nama_kelas}\n\nTELAH MELAKUKAN ABSENSI PULANG PADA PUKUL {$existing_absen->jam_pulang} TANGGAL {$formattedDate}\n",
                                'number' => $user->no_telp,
                            ]
                            ]);
                    }
                    
                    return response()->json(['success' => 'Absensi pulang berhasil']);
                }
            }
            
            $jam_masuk = $aturan_jam_siswa->jam_masuk;
            $keterangan = 'Tepat Waktu';

            if ($jam_sekarang > $jam_masuk) {
                $keterangan = 'Terlambat';
            }
            
            if ($is_siswa) {
                $inserted_absensi = AbsensiKehadiran::create([
                    'id_siswa' => $user->id,
                    'jam_masuk' => $jam_sekarang,
                    'jam_pulang' => null,
                    'status_masuk' => $keterangan,
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                ]);
            } else {
                $inserted_absensi = AbsensiKehadiranGuru::create([
                    'id_guru' => $user->id,
                    'jam_masuk' => $jam_sekarang,
                    'jam_pulang' => null,
                    'status_masuk' => $keterangan,
                    'tanggal' => Carbon::now()->format('Y-m-d'),
                ]);
            }

            if ($is_siswa && $user->no_telp != 0) {
                $formattedDate = Carbon::parse($inserted_absensi->tanggal)->locale('id')->isoFormat('D MMMM YYYY');
                
                $client = new Client;
                $request = $client->post('http://128.199.217.52/send-message', [
                    'form_params' => [
                        'message' => "INFO ABSENSI MIS JAMBE ARUM\n\nNAMA : {$user->nama_siswa}\nKELAS : {$user->kelas->nama_kelas}\n\nTELAH MELAKUKAN ABSENSI PADA PUKUL {$inserted_absensi->jam_masuk} TANGGAL {$formattedDate}\n\nSTATUS : {$inserted_absensi->status_masuk}",
                        'number' => $user->no_telp,
                    ]
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
    public function search_by_rfid(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
        ]);
        
        $user = Siswa::with('kelas')->where('rfid', $request->keyword)->first();
        if (!$user)
            $user = Guru::where('rfid', $request->keyword)->first();

        if (!$user)
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        
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
    public function destroy_siswa($id)
    {
        AbsensiKehadiran::find($id)->delete();

        return redirect()->back()->with('success', 'Absensi siswa berhasil dihapus');
    }

    public function destroy_guru($id)
    {
        AbsensiKehadiranGuru::find($id)->delete();

        return redirect()->back()->with('success', 'Absensi guru berhasil dihapus');
    }

    public function export_excel_siswa($id)
    {
        $id = Crypt::decrypt($id);
        $date = Carbon::now()->toDateString();
        return Excel::download(new AbsensiSiswaExport($id), "data-absensi-siswa-$date.xlsx");
    }

    public function export_excel_guru()
    {
        $date = Carbon::now()->toDateString();
        return Excel::download(new AbsensiGuruExport(), "data-absensi-guru-$date.xlsx");
    }
}
