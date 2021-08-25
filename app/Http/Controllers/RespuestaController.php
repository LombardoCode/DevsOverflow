<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\NotificacionesRespuesta;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RespuestaController extends Controller
{
	private $DICCIONARIO_DE_NOTIFICACIONES = array(
		'RESPUESTA_A_PREGUNTA' => 1
	);

	public function store(Request $request) {
		$reglas = [
			'contenido_html' => 'required'
		];

		$erroresPersonalizados = [
			'contenido_html.required' => 'Se requiere del cuerpo de la pregunta'
		];

		$validaciones = Validator::make($request->all(), $reglas, $erroresPersonalizados);

		if ($validaciones->fails()) {
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			$respuesta = new Respuesta([
				'user_id' => Auth::user()->id,
				'pregunta_id' => $request['pregunta_id'],
				'contenido_html' => $request['contenido_html'],
				'mejor_respuesta' => 0
			]);

			// Si la respuesta se ha guardado en la base de datos...
			if ($respuesta->save()) {
				$respuesta = json_decode(json_encode($respuesta), true);

				// Obtenemos el nombre del autor de la respuesta
				$respuesta['autor']['id'] = Auth::user()->id;
				$respuesta['autor']['nombre'] = Auth::user()->name;

				// Agregamos la cantidad de votos positivos y votos negativos
				$respuesta['votos_positivos'] = 0;
				$respuesta['votos_negativos'] = 0;

				// Formateamos la fecha de creación
				$respuesta['created_at'] = Carbon::parse($respuesta['created_at'])->diffForHumans();

				// Obtenemos los datos de la pregunta
				$pregunta = Pregunta::find($request['pregunta_id']);

				// Creamos una notificación para el usuario que creó la pregunta
				if (Auth::user()->id != $pregunta->user_id) {
					$notificacion = new Notificacion([
						'usuario_a_notificar_id' => $pregunta->user_id,
						'evento_id' => $this->DICCIONARIO_DE_NOTIFICACIONES['RESPUESTA_A_PREGUNTA'],
						'visto' => false
					]);

					// Si la notificación se ha guardado...
					if ($notificacion->save()) {
						// Creamos la relación notificación_respuesta_a_pregunta - notificación
						$notificacion_respuesta_a_pregunta = new NotificacionesRespuesta([
							'pregunta_id' => $pregunta->id,
							'usuario_causante_id' => Auth::user()->id,
							'notificacion_id' => $notificacion->id
						]);

						// Guardamos la relación notificación_respuesta_a_pregunta - notificación
						$notificacion_respuesta_a_pregunta->save();
					}
				}
				return response()->json([
					'status' => true,
					'respuesta' => $respuesta
				]);
			}
		}
	}

	public function delete($pregunta_id) {
		// Obtenemos la respuesta
		$respuesta = Respuesta::find($pregunta_id);

		// Si la respuesta existe...
		if (isset($respuesta['id'])) {
			// Verificamos si el usuario es propietario de la respuesta
			$id_usuario = Auth::user()->id;
			$respuesta_user_id = $respuesta['user_id'];

			// Si el propietario coincide...
			if ($id_usuario == $respuesta_user_id) {
				// Eliminamos la respuesta
				if ($respuesta->delete()) {
					return response()->json([
						'status' => true
					]);
				}
			} else {
				return response()->json([
					'status' => false
				]);
			}
		}
	}
}
