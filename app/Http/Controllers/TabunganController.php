<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\RiwayatTabungan;
use App\Siswa;
use App\Tabungan;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function kelas_siswa()
    {
        $kelas = Kelas::get();

        return view('admin.tabungan.index', compact('kelas'));
    }

    public function kelas_siswa_show($id)
    {
        $siswa = Siswa::where('kelas_id', $id)->get();

        return view('admin.tabungan.show', compact('siswa'));
    }

    public function index()
    {
        $kelas = Kelas::get();

        return view('admin.tabungan.index', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required',
            'jenis_tabungan' => 'required' 
        ]);

        $tabungan_cek = Tabungan::where('siswa_id', $request->siswa_id)->first();

        if($request->jenis_tabungan == 'menabung') {
            if($tabungan_cek){
                RiwayatTabungan::create([
                    'siswa_id' => $request->siswa_id,
                    'nominal' => $request->nominal,
                    'jenis_tabungan' => $request->jenis_tabungan,
                ]);
    
                $tabungan_cek->update(['saldo' => $tabungan_cek->saldo + $request->nominal]);
            } else {
                RiwayatTabungan::create([
                    'siswa_id' => $request->siswa_id,
                    'nominal' => $request->nominal,
                    'jenis_tabungan' => $request->jenis_tabungan,
                ]);
    
                Tabungan::create([
                    'siswa_id' => $request->siswa_id,
                    'saldo' => $request->nominal
                ]);
            }
        } else {
            if($tabungan_cek){
                if(intval($tabungan_cek->saldo) < intval($request->nominal)){
                    return redirect()->back()->with('warning', 'Maaf penarikan tabungan gagal karena jumlah saldo kurang');
                }

                RiwayatTabungan::create([
                    'siswa_id' => $request->siswa_id,
                    'nominal' => $request->nominal,
                    'jenis_tabungan' => $request->jenis_tabungan,
                ]);
    
                $tabungan_cek->update(['saldo' => $tabungan_cek->saldo - $request->nominal]);
                return redirect()->back()->with('success','Berhasil menarik tabungan sebesar Rp. ' . number_format($request->nominal, 0, ',', '.'));
            } else {
                return redirect()->back()->with('warning', 'Siswa ini belum memiliki tabungan!');
            }
        }

        return redirect()->back()->with('success', 'Dana Tabungan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Siswa::find($id);
        $riwayat_tabungan = RiwayatTabungan::where('siswa_id', $id)->orderByDesc('created_at')->get();

        return view('admin.tabungan.riwayat', compact('siswa', 'riwayat_tabungan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tabungan $tabungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tabungan $tabungan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tabungan  $tabungan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tabungan $tabungan)
    {
        //
    }
}
