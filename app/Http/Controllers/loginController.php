<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Modelos
use App\User;
// Extras
use Hash;
// Autenticacion
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class loginController extends Controller
{
    public function Acceso(Request $request){
    	$usuarios=new User(); 
        $datos=$usuarios->select('estado')->where('usuario',$request->usuario)->first();
        if ($datos['estado']=='INACTIVO') {
        	return response()->json(["error"=>'sin-activacion']);
        }

        $datos=$usuarios->select('contrasena')->where('usuario',$request->usuario)->first();
        $checkpass=Hash::check($request->pass, $datos['contrasena']);

        if ($checkpass) {
         $datos = $usuarios->select('id_usuario','usuario')->where('usuario',$request->usuario)->first();
         $token = JWTAuth::fromUser($datos);
         return response()->json(compact('token'));
        }else{
        	return response()->json(["error"=>'usuario-pass-fail']);
        }
    	// return response()->json(["respuesta"=>bcrypt($request->pass)]);
           
    }
}
