<?php

namespace App\Http\Controllers;

use App\Deudas;

use Illuminate\Http\Request;
use App\Http\Controllers\CuotasController;
use Ramsey\Uuid\Uuid;
class DeudasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Deudas::all();
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
        $cuotas=new CuotasController();
        $deuda= new Deudas();
        $deuda->id=(string)Uuid::uuid1();
        $deuda->cantidad=$request->cantidad;
        $deuda->fecha=$request->fecha;
        $deuda->usuario_id=$request->usuario_id;
        $deuda->nombre_deuda=$request->nombre_deuda;
        $deuda->pagado=0;
        $deuda->cuota=$request->cuota;
        $deuda->cuota_calculo=$request->cuota_calculo;

        $deuda->save();
        for($i=0;$i<$request->cuota;$i++){
            $request->nombre_cuota=$request->nombre_deuda." ". $i;
            $request->cantidad_cuota=$request->cantidad/$request->cuota_calculo;
            $request->deuda_id=$deuda->id;
            $cuotas->store($request);
           }
        $data=[
            "mensaje"=>"Deuda creada",
            "status"=>200,
            "deuda" => $deuda
        ];

        return response()->json($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $deudas=[];
        $cuotas=[];
        $sumadeudas=0.0;
        $datos= Deudas::where('usuario_id',$id)->where('pagado',0)->where('cuota_calculo','>',0)->get();
        foreach($datos as $data){
            array_push($deudas,(($data->cantidad* $data->cuota_calculo)/$data->cuota));
        }

        $sumadeudas=array_sum($deudas);

        $datosdeuda=[
            "deudas"=>$datos,
            "total"=>$sumadeudas
        ];


        return response()->json($datosdeuda);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function edit(Deudas $deudas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
        $deuda_cuota= Deudas::findOrFail($id);
        $deuda_cuota->cuota_calculo=$deuda_cuota->cuota_calculo-1;
        /*if($deuda_cuota->calculo==0){
            Deudas::where('id',$id)->delete();
        }*/
        $deuda=Deudas::where('id',$id)->update($deuda_cuota->toArray());



        $data=[
            "deudas"=>$deuda_cuota,
            "status"=>200
        ];

        return response()->json($deuda_cuota);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Deudas::where('id',$id)->delete();
    }


//Id = es el id de la deuda
//id2 = es el id de usuario
    public function verdeuda($id){

        $datos= Deudas::where('id',$id)->get();
        return response()->json($datos);
    }


    //FUNCION QUE SE LLAMA PARA CUANDO LA DEUDA FUE PAGADA POR COMPLETO
    public function deuda_pagada($id){

        $deuda_pagada= Deudas::findOrFail($id);
        $deuda_pagada->pagado=1;
        /*if($deuda_cuota->calculo==0){
            Deudas::where('id',$id)->delete();
        }*/
        $deuda=Deudas::where('id',$id)->update($deuda_pagada->toArray());



        $data=[
            "deudas"=>$deuda_pagada,
            "status"=>200
        ];

        return response()->json($deuda_pagada);
    }
}
