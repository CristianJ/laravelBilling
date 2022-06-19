<?php

namespace App\Http\Controllers;

use App\Gastos;
use App\Cgastos;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $gastos=[];
        $suma=0.0;


        $gasto=Gastos::with(['usuarios','categorias'])->get();
        for($i=0;$i<count($gasto);$i++){
                array_push($gastos,$gasto[$i]->cantidad_gasto);

        }

        for($i=0;$i<count($gastos);$i++){
            $suma=$suma+$gastos[$i];
        }

        $data=[
            "gastos"=>$gasto,
            "suma"=>$suma

        ];

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
        date_default_timezone_set('America/Guayaquil');
        $gastos=new Gastos();
        $gastos->id= (string)Uuid::uuid1();
        $gastos->nombre_gasto=$request->nombre_gasto;
        $gastos->cantidad_gasto=$request->cantidad_gasto;
        $gastos->user_id=$request->user_id;
        $gastos->categoria_id=$request->categoria_id;
        $gastos->fecha=substr($request->fecha,0,10)." " . date('H:i:s');

        $gastos->save();
        $data=[
            "message"=>"success",
            "status"=>200
        ];

        return response()->json($data);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gastos  $gastos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $gastos=[];
        $suma=0.0;

        $gasto= Gastos::where('user_id',$id)->with(['usuarios','categorias'])->orderBy('fecha','desc')->paginate(15);
        $gasto_total=Gastos::where('user_id',$id)->with(['usuarios','categorias'])->orderBy('fecha','desc')->get();

        for($i=0;$i<count($gasto_total);$i++){
            array_push($gastos,$gasto_total[$i]->cantidad_gasto);

    }

    for($i=0;$i<count($gastos);$i++){
        $suma=$suma+$gastos[$i];
    }

    $data=[
        "gastos"=>$gasto,
        "suma"=>$suma

    ];

    return response()->json($data);
    }

    public function vergasto($id)
    {
        //
        return Gastos::where('id',$id)->with(['usuarios','categorias'])->first();

    }
 public function paginar() {

    return Gastos::orderBy('id','desc')->paginate(15);


   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gastos  $gastos
     * @return \Illuminate\Http\Response
     */
    public function edit(Gastos $gastos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gastos  $gastos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $gasto=new Gastos();
        $gasto->nombre_gasto=$request->nombre_gasto;
        $gasto->cantidad_gasto=$request->cantidad_gasto;
        $gasto->user_id=$request->user_id;
        $gasto->categoria_id=$request->categoria_id;
        $gasto->fecha=substr($request->fecha,0,10)." " . date('H:i:s');

        Gastos::where('id',$id)->update($gasto->toArray());

        $data=[
            "mensaje"=>"success",
            "status"=>200
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gastos  $gastos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         Gastos::where('id',$id)->delete();
         return response()->json("Se ha borrado el gasto");
    }


    public function verfechas($id,$fecha_inicio,$fecha_fin,$categoria){
        $data=[];
        $data_cgastos=[];
$suma=0.0;
$suma_cgastos=0.0;

        (array)$dato=Gastos::with(['usuarios','categorias'])->where("user_id",$id)->whereBetween('fecha',[$fecha_inicio,$fecha_fin])->orderBy('fecha',"asc")->get();


        (array)$dato_cgastos=Cgastos::with(['cuentas','categorias'])->whereHas('cuentas' , function($q) use($id){
               $q->where('user_id', $id);


           })->whereBetween('fecha',[$fecha_inicio,$fecha_fin])->orderBy('fecha',"asc")->get();

            foreach($dato as $item){

                if($categoria==0){
                    array_push($data,$item);
                }
                else if($item->categoria_id==$categoria){
                    array_push($data,$item);

                }

            }


            foreach($dato_cgastos as $item){

                if($categoria==0){
                    array_push($data_cgastos,$item);
                }
                else if($item->categorias_id==$categoria){
                    array_push($data_cgastos,$item);

                }

            }


            for($i=0;$i<count($data);$i++){
                $suma=$suma+$data[$i]->cantidad_gasto;
            }

             for($i=0;$i<count($data_cgastos);$i++){
                $suma_cgastos=$suma_cgastos+$data_cgastos[$i]->cantidad;
            }




            $data_json=[
                "data_fisica"=>$data,
                "suma_fisica"=>$suma,
                "data_banco"=>$data_cgastos,
                "suma_banco"=>$suma_cgastos

            ];


            return response()->json($data_json);




    }



    public function graficas(){
        $data_agosto=[];
        $suma_agosto=0.0;
        $data_septiembre=[];
        $suma_septiembre=0.0;
        $agosto=Gastos::whereBetween('fecha',['2019-08-01','2019-08-31'])->get();
        $septiembre=Gastos::whereBetween('fecha',['2019-09-01','2019-09-30'])->get();
       foreach($agosto as $item){
           array_push($data_agosto,$item->cantidad_gasto);
       }
       $suma_agosto=array_sum($data_agosto);
       foreach($septiembre as $item){
           array_push($data_septiembre,$item->cantidad_gasto);
       }
       $suma_septiembre=array_sum($data_septiembre);


       $data=[
           "agosto"=>$suma_agosto,
           "septiembre"=>$suma_septiembre];


           return response()->json($data);
    }




}
