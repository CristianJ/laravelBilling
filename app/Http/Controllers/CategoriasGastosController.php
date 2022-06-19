<?php

namespace App\Http\Controllers;

use App\CategoriasGastos;
use Illuminate\Http\Request;

class CategoriasGastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return CategoriasGastos::select()->orderBy('nombre_categoria','asc')->get();
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
     * @param  \App\CategoriasGastos  $categoriasGastos
     * @return \Illuminate\Http\Response
     */
    public function show(CategoriasGastos $categoriasGastos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategoriasGastos  $categoriasGastos
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoriasGastos $categoriasGastos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoriasGastos  $categoriasGastos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriasGastos $categoriasGastos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategoriasGastos  $categoriasGastos
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoriasGastos $categoriasGastos)
    {
        //
    }
}
