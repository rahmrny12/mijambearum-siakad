<?php

namespace App\Http\Controllers;

use App\AbsensiKehadiran;
use Illuminate\Http\Request;

class AbsensiKehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('absensi_kehadiran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AbsensiKehadiran  $absensiKehadiran
     * @return \Illuminate\Http\Response
     */
    public function show(AbsensiKehadiran $absensiKehadiran)
    {
        //
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
