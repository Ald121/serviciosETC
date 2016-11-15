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
    	$currentPage = $request->page;
   		$limit = $request->limit;

    	$temas=DB::table('temas')->where('id_usuario',$this->user['id_usuario'])->get();
    	$temas=$this->funciones->paginarDatos($temas,$currentPage,$limit);
    	return response()->json(['respuesta'=>$temas]);
    }

    public function addRoom(Request $request){
        $saludo = ($request->has('saludo')) ? $request->input('saludo') : "Un amigo te ha invitado";
        $cuerpo=($request->has('cuerpo')) ? $request->input('cuerpo'):"A continuación se detallan los datos para ingresar a la video conferencia";
        DB::table('temas')->insert(['nombre_tema' => $request->input('nombre_tema'), 'fecha' => Carbon::now()->toDateString(), 'hora' => Carbon::now()->format('H:i'), 'pass_sala' => 'N3xQxx@99', 'estado' =>'ENESPERA','saludo'=>$saludo,'cuerpo'=>$cuerpo,'id_usuario'=>$this->user['id_usuario']]);
        foreach ($request->invitados as $key => $value) {
            $clave_sala=$this->funciones->generarPass();
            DB::table('login_sala')->insert(['pass_user' => $clave_sala, 'id_usuario' => $value['id_usuario'], 'nombre_sala' => $request->input('nombre_tema')]);
            $data=['correo'=>$value['email'],'nombre_user'=>$value['nombres'].' '.$value['apellidos'],'saludo'=>$saludo,'cuerpo'=>$cuerpo,'pass_sala'=>$clave_sala,'tema'=>$request->input('nombre_tema')];
           // $this->enviar_credenciales_sala($data);
        }
        return response()->json(['respuesta'=>true]);
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
