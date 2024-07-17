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

        if ($request->id) {
            AturanJamSiswa::find($request->id)->update([
                'nama_aturan' => $request->nama_aturan,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'status' => $request->status,
            ]);
        } else {
            AturanJamSiswa::create([
                'nama_aturan' => $request->nama_aturan,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
                'status' => $request->status,
            ]);
        }

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
        $aturan_jam_siswa->update(['status' => 0]);
        $aturan_jam_siswa->delete();
        return redirect()->back()->with('warning', 'Aturan jam siswa berhasil dihapus.');
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

    public function trash()
    {
        $aturan_jam_siswa = AturanJamSiswa::onlyTrashed()->get();
        return view('admin.aturan_jam_siswa.trash', compact('aturan_jam_siswa'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $aturan_jam_siswa = AturanJamSiswa::withTrashed()->findorfail($id);
        $aturan_jam_siswa->restore();
        return redirect()->back()->with('info', 'Data aturan jam siswa berhasil direstore! (Silahkan cek data aturan jam siswa)');
    }

    public function kill($id)
    {
        $aturan_jam_siswa = AturanJamSiswa::withTrashed()->findorfail($id);
        $aturan_jam_siswa->forceDelete();
        return redirect()->back()->with('success', 'Data aturan jam siswa berhasil dihapus secara permanent');
    }
}
