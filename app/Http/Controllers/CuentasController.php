<?php

namespace App\Http\Controllers;

use App\Cuentas;
use App\Cgastos;
use App\Cingresos;
use Illuminate\Http\Request;

class CuentasController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cuentas  $cuentas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $ingresos=[];
        $gastos=[];

        $datos= Cuentas::with(['cingresos','cgastos'])->where('user_id',$id)->orderBy('id','desc')->get();

        return response()->json($datos);

        foreach($datos as $data){
            array_push($ingresos,$data->cingresos);
        }

        for($i=0;$i<count($ingresos);$i++){

            return response()->json($ingresos[$i]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cuentas  $cuentas
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuentas $cuentas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cuentas  $cuentas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuentas $cuentas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cuentas  $cuentas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuentas $cuentas)
    {
        //
    }

    //Metodo que devuelve el usuario y los bancos asociados
    public function cuentasusuario($user_id,$banco_id){
        $ingresos=[];
        $ingresos1=[];
        $totalingresos=0.0;
        $gastos=[];
        $gastos1=[];
        $totalgastos=0.0;
        $total=0.0;
        $datos= Cuentas::where('user_id',$user_id)
        ->where('banco_id',$banco_id)
        ->with(['bancos','usuarios','cingresos','cgastos'])->get();

        foreach($datos as $data){
            $gastos=($data->cgastos);
            $ingresos=$data->cingresos;

        }

        foreach($gastos as $item){
           array_push($gastos1,$item->cantidad) ;
        }

        foreach($ingresos as $item){
            array_push($ingresos1,$item->cantidad) ;
         }

        for($i=0;$i<count($gastos1);$i++){
            $totalgastos=$totalgastos+$gastos1[$i];
        }

        for($i=0;$i<count($ingresos1);$i++){
            $totalingresos=$totalingresos+$ingresos1[$i];
        }
        $sumas=[
            "datos"=>$datos,
            "total"=>($totalingresos-$totalgastos)
        ];
        return response()->json($sumas);

    }

    //Metodo que devuelve los gastos que se hizo con tarjeta
    public function cgastospaginados($id){

        $gastos_paginados=Cgastos::where('cuentas_id',$id)->with(['categorias'])->orderBy('fecha','desc')->paginate(15);
        $suma=Cgastos::where('cuentas_id',$id)->sum('cantidad');

        $datos=[
            'gastos'=>$gastos_paginados,
            'suma'=>$suma
        ];

        return response()->json($datos);

    }

    //Metodo que devuelve el usuario y los bancos asociados
    public function cingresospaginados($id){

        $gastos_paginados=Cingresos::where('cuentas_id',$id)->with(['categorias'])->orderBy('fecha','desc')->paginate(15);
        $suma=Cingresos::where('cuentas_id',$id)->sum('cantidad');

        $datos=[
            'ingresos'=>$gastos_paginados,
            'suma'=>$suma
        ];

        return response()->json($datos);

    }

    //Metodo que devuelve el usuario segun el numero de cuenta
    public function cuentaid($user_id,$cuenta_id){
        return Cuentas::where('id',$cuenta_id)->where('user_id',$user_id)->with(['cingresos','cgastos'])->get();
    }

    public function cuentabanco($cuenta_id){
        return Cuentas::with(['bancos'])->where('id',$cuenta_id)->get();
    }

    public function cuentabancoXUsuario($id){
        return Cuentas::with(['bancos'])->where('user_id',$id)->get();
    }

    public function getCuentaByBanco($user_id,$banco_id){
        return Cuentas::where('banco_id',$banco_id)->where('user_id',$user_id)->get();
    }
}
