<?php

namespace App\Http\Controllers;

use App\Usuarios;
use App\Cuentas;
use App\User;
use App\Cingresos;
use App\Cgastos;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::with(['ingresos','gastos','deudas'])->get();
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


    public function login(Request $request){
        $usuario=User::where('email',$request->email)->get()->first();//->load('roles')->first();


       if($usuario && \Hash::check($request->password,$usuario->password) ){
          // $token=self::getToken($request->email, $request->password);

           $payloadable = [
               'id' => $usuario->id,
               'nombre' => $usuario->nombre,
               //'roles' => $usuario->roles,

           ];

          $token= JWTAuth::customClaims($payloadable)->attempt(['email' =>$request->email , 'password' => $request->password]);


           $respuesta=['token'=>$token,'success'=>true,'data'=>'Bienvenido'];
           return response()->json($respuesta,201);

       }else{

           $respuesta=['success'=>false,'data'=>'Usuario o contraseña no encontrados'];
           return response()->json($respuesta,400);
       }

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

         //Instancio la clase Usuario
         $usuario=new Usuarios();
         //$roles=new UsuariosRoles();
         //$sedes=new Sedes();
         //Declaro el nombre enviado desde frontend
         $usuario->nombre=$request->nombre;
         $usuario->email=$request->email;
         $usuario->password=\Hash::make($request->password);
         $usuario->celular=$request->celular;
         $usuario->foto=$request->foto;
         $usuario->save();






         $data=array('status'=>'success','code'=>200,'mensaje'=>'Usuario Creado correctamente');

         return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $ingresos1=[];
        $ingresos2=[];
        $sumaingresos=0.0;
        $gastos1=[];
        $gastos2=[];
        $sumagastos=0.0;
        $cgasto=[];
        $suma_cgasto=0.0;
        $cingreso=[];
        $suma_cingreso=0.0;
        $usuario= Usuarios::with(['ingresos','gastos','cuentas.cgastos','cuentas.cingresos','deudas'])->where('id',$id)->get();
        $usuarios= Usuarios::where('id',$id)->first();
        $cgastos=Cgastos::with(['cuentas'])->whereHas('cuentas' , function($q) use($id){
               $q->where('user_id', $id);

           })->get();

         $cingresos=Cingresos::with(['cuentas'])->whereHas('cuentas' , function($q) use($id){
               $q->where('user_id', $id);

           })->get();

        foreach($usuario as $item){
           //
           $ingresos1=$item->ingresos;
            //
        }

        foreach($usuario as $item){
            $gastos1=$item->gastos;
        }

        foreach($cgastos as $item){

            if($item->categorias_id!=15 && $item->categorias_id!=22){
                array_push($cgasto,$item->cantidad);
            }

        }

        foreach($cingresos as $item){
            if($item->categorias_id!=18 && $item->categorias_id!=14 ){
                array_push($cingreso,$item->cantidad);
            }


        }

        for($i=0;$i<count($cgasto);$i++){
            $suma_cgasto=$suma_cgasto + $cgasto[$i];
        }

        for($i=0;$i<count($cingreso);$i++){
            $suma_cingreso=$suma_cingreso + $cingreso[$i];
        }

        for($i=0;$i<count($ingresos1);$i++){
            array_push($ingresos2,$ingresos1[$i]->cantidad_ingreso);
            $sumaingresos=$sumaingresos+$ingresos2[$i];

        }

        for($i=0;$i<count($gastos1);$i++){
            array_push($gastos2,$gastos1[$i]->cantidad_gasto);
            $sumagastos=$sumagastos+$gastos2[$i];

        }

        $data=[
            "usuario"=>$usuarios,
            "totalingreso"=>round($sumaingresos,2),
            "totalgasto"=> round($sumagastos,2),
            "c_ingresos"=>round($suma_cingreso,2),
            "c_gastos"=>round($suma_cgasto,2)
        ];

        return response()->json($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuarios $usuarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuarios $usuarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuarios $usuarios)
    {
        //
    }

    public function getUserData($id){
        $usuarios= Usuarios::where('id',$id)->get();
        return response()->json($usuarios);
    }

    public function getBankData($id){
        $bancos=[];
        $data=[];
        $datos_finales=[];
        $gastos=0;

       $usuarios=Usuarios::with(['cuentas.bancos','cuentas.cingresos'])->where('id',$id)->get();
       foreach($usuarios as $user){
           foreach($user['cuentas'] as $item){

               array_push($bancos,$item->bancos);
           }
       }


        foreach($bancos as $banco){
            $datos= Cuentas::where('user_id',$id)->where('banco_id',$banco->id)->with(['bancos','cingresos','cgastos'])->get();
            array_push($data,$datos[0]);
        }


        foreach($data as $key=>$item){
            array_push($datos_finales,["id"=>$item->id,"user_id"=>$id,"cuenta_id"=>$item->id,"banco_id"=>$item->bancos['id'],"nombre"=>$item->bancos['nombre_banco'],
            "ingresos"=>round(array_sum(array_column($item['cingresos']->toArray(),'cantidad')),2),
            "gastos"=>round(array_sum(array_column($item['cgastos']->toArray(),'cantidad')),2),
            "total"=>round(array_sum(array_column($item['cingresos']->toArray(),'cantidad')),2)-round(array_sum(array_column($item['cgastos']->toArray(),'cantidad')),2)
        ]);
        }


        return response($datos_finales);

    }
}
