<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\NotificacionesRespuesta;
use App\Models\Pregunta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
	private $DICCIONARIO_DE_NOTIFICACIONES = array(
		'RESPUESTA_A_PREGUNTA' => 1
	);

	public function all() {
		//
		$notificaciones_frontend = [];
		// Obtenemos las notificaciones del usuario actual
		$notificaciones = Notificacion::where('usuario_a_notificar_id', '=', Auth::user()->id)
		->limit(10)
		->offset(0)
		->get();

		// Recorremos las notificaciones
		for ($i=0; $i < count($notificaciones); $i++) {
			$notificacion = $notificaciones[$i];
			$evento = $notificacion['evento_id'];

			if ($evento == $this->DICCIONARIO_DE_NOTIFICACIONES['RESPUESTA_A_PREGUNTA']) {
				// Obtenemos la relación
				$relacion = NotificacionesRespuesta::where('notificacion_id', '=', $notificacion['id'])->get();
				$relacion = $relacion[0];

				// Obtenemos la pregunta
				$pregunta = Pregunta::find($relacion['pregunta_id']);

				// Obtenemos al usuario que creó la notificación
				$usuario_causante = User::find($relacion['usuario_causante_id']);

				// Formulamos la notificación
				$notificaciones_frontend[$i]['mensaje'] = $usuario_causante->name . ' ha contestado a tu pregunta.';
				$notificaciones_frontend[$i]['cuerpo'] = 'Pregunta "' . $pregunta->pregunta . '"';
				$notificaciones_frontend[$i]['created_at'] = $notificacion['created_at'];
				$notificaciones_frontend[$i]['url'] = '/pregunta/' . $pregunta->identificador;
				$notificaciones_frontend[$i]['visto'] = $notificacion['visto'];
			}
		}

		return response()->json([
			'status' => true,
			'notificaciones' => $notificaciones_frontend
		]);
	}
}
