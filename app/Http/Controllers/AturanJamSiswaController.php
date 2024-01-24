<?php

namespace App\Http\Controllers;

use App\AbsensiKehadiran;
use App\AturanJamSiswa;
use App\Kelas;
use App\Guru;
use App\Paket;
use App\Jadwal;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AturanJamSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aturan_jam_siswa = AturanJamSiswa::OrderBy('nama_aturan', 'asc')->get();
        return view('admin.aturan_jam_siswa.index', compact('aturan_jam_siswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guru = Guru::OrderBy('nama_guru', 'asc')->get();
        return view('admin.kelas.create', compact('guru'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_aturan' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        if ($request->status == 1) {
            AturanJamSiswa::where('id', '!=', $request->id)->update(['status' => 0]);
        }

        AturanJamSiswa::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'nama_aturan' => $request->nama_aturan,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'status' => $request->status,
            ]
        );

        return redirect()->back()->with('success', 'Data Aturan Jam Siswa berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aturan_jam_siswa = AturanJamSiswa::findorfail($id);
        $countAbsen = AbsensiKehadiran::where('aturan_jam_siswa_id', $aturan_jam_siswa->id)->count();
        if ($countAbsen >= 1) {
            return redirect()->back()->with('warning', 'Data aturan jam siswa sudah digunakan!');
        }
        $aturan_jam_siswa->delete();
        return redirect()->back()->with('warning', 'Data kelas berhasil dihapus! (Silahkan cek trash data kelas)');
    }
    
    public function getEdit(Request $request)
    {
        $aturan_jam_siswa = AturanJamSiswa::where('id', $request->id)->get();
        foreach ($aturan_jam_siswa as $val) {
            $newForm[] = array(
                'id' => $val->id,
                'nama_aturan' => $val->nama_aturan,
                'jam_masuk' => $val->jam_masuk,
                'jam_pulang' => $val->jam_pulang,
                'status' => $val->status,
            );
        }
        return response()->json($newForm);
    }
}
