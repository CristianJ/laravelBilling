<?php

namespace App\Http\Controllers;

use App\CategoriasIngresos;
use Illuminate\Http\Request;

class CategoriasIngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return CategoriasIngresos::select()->orderBy('nombre_categoria','asc')->get();
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
     * @param  \App\CategoriasIngresos  $categoriasIngresos
     * @return \Illuminate\Http\Response
     */
    public function show(CategoriasIngresos $categoriasIngresos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategoriasIngresos  $categoriasIngresos
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoriasIngresos $categoriasIngresos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoriasIngresos  $categoriasIngresos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriasIngresos $categoriasIngresos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategoriasIngresos  $categoriasIngresos
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoriasIngresos $categoriasIngresos)
    {
        //
    }
}
