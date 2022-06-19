<?php

namespace App\Http\Controllers;

use App\Cuotas;
use App\Deudas;
use Illuminate\Http\Request;
use App\Http\Controllers\DeudasController;
use Ramsey\Uuid\Uuid;

class CuotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $cuotas=new Cuotas();
        $cuotas->id=(string)Uuid::uuid1();
        $cuotas->deuda_id=$request->deuda_id;
        $cuotas->nombre_cuota=$request->nombre_cuota;
        $cuotas->cantidad_cuota=$request->cantidad_cuota;
        $cuotas->save();
        $data=[
            "message"=>"success",
            "status"=>200
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cuotas  $cuotas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cuotas=[];
        $total=0.0;

        $datos= Cuotas::where('deuda_id',$id)->orderby('nombre_cuota','asc')->get();

        foreach($datos as $data){
            array_push($cuotas,$data->cantidad_cuota);
        }

       $total= array_sum($cuotas);

        $respuesta=[
            'deuda'=>$datos,
            'total'=>$total
            ];

            return response()->json($datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cuotas  $cuotas
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuotas $cuotas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cuotas  $cuotas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuotas $cuotas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cuotas  $cuotas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deudas=new DeudasController();
        $deuda=Cuotas::where('id',$id)->first();
        $cuotas_id=Deudas::where('id',$deuda['deuda_id'])->first();



        $cuotas= Cuotas::where('id',$id)->delete();


        $respuesta=[

            "mensaje"=>"Cuota eliminada",
            "deuda"=>$deuda

            ];



        if($cuotas_id['cuota_calculo']==0){
            $deudas->deuda_pagada($deuda->deuda_id);
        }
        $deudas->update($deuda->deuda_id);


        return response()->json($respuesta);
    }
}
