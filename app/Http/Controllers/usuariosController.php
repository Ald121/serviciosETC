<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Modelos
use App\User;
// Extras
use DB;
use App\libs\Funciones;
use Carbon\Carbon;
use Storage;
use File;
// Autenticacion
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class usuariosController extends Controller
{
   public function __construct(){
		//-------------------------- Autenticacion------
        $this->user = JWTAuth::parseToken()->authenticate();
        // Funciones
        $this->funciones=new Funciones();
        // Modelos
        $this->usuarios=new User(); 
        // Almacenamiento
        // $this->pathLocal  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
	}

    public function getAmigos(Request $request){
    	$currentPage = $request->page;
   		$limit = $request->limit;

    	$usuarios=$this->usuarios->where('id_usuario','!=',$this->user['id_usuario'])->get();
        foreach ($usuarios as $key => $value) {
            if (File::exists($value['foto'])) {
                    $usuarios[$key]['foto']=$value['foto'];
                }else{
                    $usuarios[$key]['foto']='storage/app/perfiles/avatar-default.png';
                }
        }

    	$usuarios=$this->funciones->paginarDatos($usuarios,$currentPage,$limit);
    	return response()->json(['respuesta'=>$usuarios]);
    }

    // public function deleteAmigo(Request $request){
    //     foreach ($request->rooms as $key => $value) {
    //         DB::table('usuarios')->where('id_usuario',$value['id_usuario'])->where('id_usuario',$this->user['id_usuario'])->delete();
    //     }
    //     return response()->json(['respuesta'=>true]);
    // }
    

    public function addAmigo(Request $request){

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
            'tipo_user'=>$request->input('tipo_user'),
            'ip_user'=>$request->ip(),
            'foto'=>$foto,
            'cedula'=>$request->input('cedula'),
            'direccion'=>$request->input('direccion'),
            'celular'=>$request->input('celular')]
            );

        return response()->json(['respuesta'=>$save]);
    }

}
