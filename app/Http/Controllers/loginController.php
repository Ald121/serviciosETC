<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Modelos
use App\User;
// Extras
use Hash;
use DB;
use App\libs\Funciones;
use Carbon\Carbon;
use Storage;
use File;
// Autenticacion
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class loginController extends Controller
{

    public function __construct(){
        // Funciones
        $this->funciones=new Funciones();
    }

    public function Acceso(Request $request){
    	$usuarios=new User(); 
        $datos=$usuarios->select('estado')->where('usuario',$request->usuario)->first();
        if ($datos['estado']=='INACTIVO') {
        	return response()->json(["respuesta"=>false,"error"=>'sin-activacion']);
        }

        $datos=$usuarios->select('contrasena')->where('usuario',$request->usuario)->first();
        $checkpass=Hash::check($request->pass, $datos['contrasena']);

        if ($checkpass) {
         $datos = $usuarios->select('id_usuario','nombres','apellidos','tipo_user','foto')->where('usuario',$request->usuario)->first();
         $token = JWTAuth::fromUser($datos);
         $ip=$request->ip();
         return response()->json(["respuesta"=>true,'datosUser'=>$datos,'token'=>$token]);
        }else{
        	return response()->json(["respuesta"=>false,"error"=>'usuario-pass-fail']);
        }
    	// return response()->json(["respuesta"=>bcrypt($request->pass)]);
    }

    public function Registro(Request $request){

        if ($request->has('fecha_nac')) {
              $fecha=explode('(', $request->input('fecha_nac'));
                $now = Carbon::now();
                $end = Carbon::parse($fecha[0]);
                $edad = $end->diff($now)->format('%y');
        }else{
             $edad = '00';
        }

        if ($request->hasFile('file')) {
        $id_img=$this->funciones->generarID();
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        Storage::put('/perfiles/'.$id_img.'.'.$extension,  File::get($file));
        $foto="storage/app/perfiles/".$id_img.'.'.$extension;
        }else{
            $foto="storage/app/avatar-default.png";
        }
     
        $save=DB::table('usuarios')->insert(
            ['nombres'=>$request->input('nombres'),
            'apellidos'=>$request->input('apellidos'),
            'edad'=>$edad,
            'usuario'=>$request->input('user'),
            'contrasena'=>bcrypt($request->input('pass')),
            'fecha_registro'=>Carbon::now()->toDateString(),
            'estado'=>'ACTIVO',
            'email'=>$request->input('email'),
            'tipo_user'=>'CLIENTE',
            'ip_user'=>$request->ip(),
            'foto'=>$foto,
            'cedula'=>$request->input('cedula'),
            'direccion'=>$request->input('direccion'),
            'celular'=>$request->input('celular')]
            );

        return response()->json(['respuesta'=>$save]);
    }
}
