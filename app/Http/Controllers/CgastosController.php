<?php

namespace App\Http\Controllers;

use App\Cgastos;
use App\Ingresos;
use App\CIngresos;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CgastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bancos=[];
        $data = Cgastos::with(['cuentas'])->get();

        return response()->json($data);

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
        $gasto=new Cgastos();
        $gasto->id=(string)Uuid::uuid1();
        $gasto->nombre_gasto=$request->nombre_gasto;
        $gasto->cantidad=$request->cantidad;
        $gasto->fecha=$request->fecha;
        $gasto->cuentas_id=$request->cuentas_id;
        $gasto->categorias_id=$request->categorias_id;
        $gasto->iva_transaccion=$request->iva;
        if($gasto->categorias_id==15 ){
           $this->postIngresoFisicoPorRetiroBancario($request);
        }

        if($gasto->iva_transaccion==1){
            $this->postGastoBancarioPorRetiro($request,'iva');
        }

        if($gasto->categorias_id==22){
            //$this->postGastoBancarioPorRetiro($request,'transaccionCuenta');
            $this->postIngresoPorRetiro($request,'transaccionCuenta');
        }

        if(($request->transaccion_bancaria_iva=='true' && $gasto->categorias_id==22) ||
           ($request->transaccion_bancaria_iva=='true' && $gasto->categorias_id==18) ){
            $this->postGastoBancarioPorRetiro($request,'transaccionIvaCuenta');
        }

        $gasto->save();
        $data=[
            "mensaje"=>"gasto ingresado correctamente",
            "status"=>200,
            "request"=>$request,
            "valor"=>gettype($request->transaccion_bancaria_iva)
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cgastos  $cgastos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Cgastos::where('cuentas_id',$id)->orderBy('id','desc')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cgastos  $cgastos
     * @return \Illuminate\Http\Response
     */
    public function edit(Cgastos $cgastos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cgastos  $cgastos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gasto=new CGastos();
        $gasto->nombre_gasto=$request->nombre_gasto;
        $gasto->cantidad=$request->cantidad;
        $gasto->fecha=substr($request->fecha,0,10)." " . date('H:i:s');
        $gasto->cuentas_id=$request->cuentas_id;
        $gasto->categorias_id=$request->categorias_id;

        $gasto->iva_transaccion=$request->iva;
        if($gasto->categorias_id==15 ){
           $this->postIngresoFisicoPorRetiroBancario($request);
        }

        if($gasto->iva_transaccion==1){
            $this->postGastoBancarioPorRetiro($request,'iva');
        }

        if($gasto->categorias_id==22){
            //$this->postGastoBancarioPorRetiro($request,'transaccionCuenta');
            $this->postIngresoPorRetiro($request,'transaccionCuenta');
        }

        if(($request->transaccion_bancaria_iva=='true' && $gasto->categorias_id==22) ||
           ($request->transaccion_bancaria_iva=='true' && $gasto->categorias_id==18) ){
            $this->postGastoBancarioPorRetiro($request,'transaccionIvaCuenta');
        }

        cGastos::where('id',$id)->update($gasto->toArray());

        $data=[
            "mensaje"=>"success",
            "status"=>200
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cgastos  $cgastos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Cgastos::where('id',$id)->delete();
    }

    public function getCgasto($id){
        return Cgastos::where('id',$id)->with(['categorias'])->first();
    }



    private function postIngresoFisicoPorRetiroBancario($request){
        date_default_timezone_set('America/Guayaquil');
        $ingreso=new Ingresos();
        $ingreso->id= (string)Uuid::uuid1();
        $ingreso->nombre_ingreso=$request->nombre_gasto;
        $ingreso->cantidad_ingreso=$request->cantidad;
        $ingreso->user_id=$request->user_id;
        $ingreso->categoria_id=11;
        $ingreso->fecha=substr($request->fecha,0,10)." " . date('H:i:s');
        $ingreso->save();
    }

    private function postGastoBancarioPorRetiro($request,$accion){
        switch($accion){
            case 'iva':
                $request->cantidad=1;
                $request->nombre_gasto='Iva Transaccion Retiro';
                $request->categorias_id=21;
            break;


            case 'transaccionIvaCuenta':
                $request->cuentas_id=$request->cuentas_id;
                $request->cantidad=0.4;
                $request->nombre_gasto='Iva Transaccion Transferencia';
                $request->categorias_id=21;
            break;
        }
        date_default_timezone_set('America/Guayaquil');
        $gastos=new CGastos();
        $gastos->id=(string)Uuid::uuid1();
        $gastos->nombre_gasto=$request->nombre_gasto;
        $gastos->cantidad=$request->cantidad;
        $gastos->cuentas_id=$request->cuentas_id;
        $gastos->categorias_id=$request->categorias_id;
        $gastos->fecha=substr($request->fecha,0,10)." " . date('H:i:s');
        $gastos->iva_transaccion=0;
        $gastos->save();
    }

    private function postIngresoPorRetiro($request,$accion){
        switch($accion){
            case 'transaccionCuenta':
                $request->cantidad;
                $request->categorias_id=18;
            break;
        }

        $ingreso=new Cingresos();
        $ingreso->id=(string)Uuid::uuid1();
        $ingreso->nombre_ingreso=$request->nombre_gasto;
        $ingreso->cantidad=$request->cantidad;
        $ingreso->fecha=$request->fecha;
        $ingreso->cuentas_id=$request->cuenta_destino_id;
        $ingreso->categorias_id=$request->categorias_id;
        $ingreso->save();

    }
}
