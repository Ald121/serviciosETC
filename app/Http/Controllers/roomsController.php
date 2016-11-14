<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Modelos
// Extras
use DB;
use Mail;
use App\libs\Funciones;
use Carbon\Carbon;
// Autenticacion
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class roomsController extends Controller
{
	public function __construct(){
		//-------------------------- Autenticacion-------
        $this->user = JWTAuth::parseToken()->authenticate();
        // Funciones
        $this->funciones=new Funciones();
	}

    public function getRooms(Request $request){
    	$currentPage = $request->pagina_actual;
   		$limit = $request->limit;

    	$temas=DB::table('temas')->where('id_usuario',$this->user['id_usuario'])->get();
    	$temas=$this->funciones->paginarDatos($temas,$currentPage,$limit);
    	return response()->json(['respuesta'=>$temas]);
    }

    public function addRoom(Request $request){
        $clave_sala=$this->funciones->generarPass();
        $saludo = ($request->input('datos_sala')['saludo']=='') ? "Un amigo te ha invitado": $request->input('datos_sala')['saludo'];
        $cuerpo=($request->input('datos_sala')['cuerpo']=='') ? "A continuación se detallan los datos para ingresar a la video conferencia":$request->input('datos_sala')['cuerpo'];
        DB::table('temas')->insert(['nombre_tema' => $request->input('datos_sala')['nombre_tema'], 'fecha' => Carbon::now()->toDateString(), 'hora' => Carbon::now()->format('H:i'), 'pass_sala' => 'NNN', 'estado' =>'ENESPERA','saludo'=>$saludo,'cuerpo'=>$cuerpo,'id_usuario'=>$this->user['id_usuario']]);
        foreach ($request->invitados as $key => $value) {
            $data=['correo'=>$value['email'],'nombre_user'=>$value['nombres'].' '.$value['apellidos'],'saludo'=>$saludo,'cuerpo'=>$cuerpo,'pass_sala'=>$clave_sala,'tema'=>$request->input('datos_sala')['nombre_tema']];
           $this->enviar_credenciales_sala($data);
        }

        return response()->json(['respuesta'=>$request->input('datos_sala')['cuerpo']]);
    }

    public function enviar_credenciales_sala($data){
        $correo_enviar=$data['correo'];
        $nombre_user=$data['nombre_user'];
        $tema=$data['tema'];
        Mail::send('email_crear_sala', $data, function($message)use ($correo_enviar,$nombre_user,$tema)
            {
                $message->from("adminconferencia@innovaservineg.com",'ETC | '.$tema);
                $message->to($correo_enviar,$nombre_user)->subject('Un amigo te ha invitado');
            });
    }
}
