<?php

namespace App\Http\Controllers;

use App\Bancos;
use Illuminate\Http\Request;

class BancosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Bancos::with(['cuentas'])->get();
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
     * @param  \App\Bancos  $bancos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Bancos::where('id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bancos  $bancos
     * @return \Illuminate\Http\Response
     */
    public function edit(Bancos $bancos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bancos  $bancos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bancos $bancos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bancos  $bancos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bancos $bancos)
    {
        //
    }
}
