<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Modelos
use App\User;
// Extras
use DB;
use App\libs\Funciones;
// Autenticacion
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class usuariosController extends Controller
{
   public function __construct(){
		//-------------------------- Autenticacion---1----
        $this->user = JWTAuth::parseToken()->authenticate();
        // Funciones
        $this->funciones=new Funciones();
        // Modelos
        $this->usuarios=new User(); 
	}

    public function getAmigos(Request $request){
    	$currentPage = $request->pagina_actual;
   		$limit = $request->limit;

    	$usuarios=$this->usuarios->where('id_usuario','!=',$this->user['id_usuario'])->get();
    	$usuarios=$this->funciones->paginarDatos($usuarios,$currentPage,$limit);
    	return response()->json(['respuesta'=>$usuarios]);
    }
}
