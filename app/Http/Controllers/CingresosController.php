<?php

namespace App\Http\Controllers;
use Ramsey\Uuid\Uuid;
use App\Cingresos;
use Illuminate\Http\Request;

class CingresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ingresos=[];
        $singresos=[];
        $data = Cingresos::with('cuentas')->get();

       /* foreach($data as $dat){
            array_push($ingresos,$dat->cuentas->bancos);
        }

       foreach($ingresos as $ingre){
        array_push($singresos,$ingre);
       }*/

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
        //
        $ingreso=new Cingresos();
        $ingreso->id=(string)Uuid::uuid1();
        $ingreso->nombre_ingreso=$request->nombre_ingreso;
        $ingreso->cantidad=$request->cantidad;
        $ingreso->fecha=$request->fecha;
        $ingreso->cuentas_id=$request->cuentas_id;
        $ingreso->categorias_id=$request->categorias_id;

        $ingreso->save();
        $data=[
            "mensaje"=>"Ingreso ingresado correctamente",
            "status"=>200
        ];

        return response()->json($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cingresos  $cingresos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Cingresos::where('cuentas_id',$id)->orderBy('fecha','asc')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cingresos  $cingresos
     * @return \Illuminate\Http\Response
     */
    public function edit(Cingresos $cingresos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cingresos  $cingresos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ingreso=new CIngresos();
        $ingreso->nombre_ingreso=$request->nombre_ingreso;
        $ingreso->cantidad=$request->cantidad;
        $ingreso->fecha=substr($request->fecha,0,10)." " . date('H:i:s');
        $ingreso->cuentas_id=$request->cuentas_id;
        $ingreso->categorias_id=$request->categorias_id;

        cIngresos::where('id',$id)->update($ingreso->toArray());

        $data=[
            "mensaje"=>"success",
            "status"=>200
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cingresos  $cingresos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Cingresos::where('id',$id)->delete();


    }


    public function getCingreso($id){
        return Cingresos::where('id',$id)->with(['categorias'])->first();
    }
}
