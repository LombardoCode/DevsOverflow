<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\VotoPregunta;
use App\Models\VotoRespuestas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PreguntaController extends Controller
{
	public function mostrar_vista_crear_pregunta() {
		return view('auth.crear_pregunta', [
			'titulo' => 'Crear pregunta'
		]);
	}

	public function store(Request $request) {
		$reglas = [
			'titulo' => 'required',
			'contenido_html' => 'required'
		];

		$erroresPersonalizados = [
			'titulo.required' => 'Se requiere de un título para la pregunta.',
			'contenido_html.required' => 'Se requiere del cuerpo de la pregunta'
		];

		$validaciones = Validator::make($request->all(), $reglas, $erroresPersonalizados);

		if ($validaciones->fails()) {
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			$identificador_aleatorio = $this->generarIdentificador(16);

			$resumen_pregunta = strip_tags($request['contenido_html']);
			$resumen_pregunta = substr($resumen_pregunta, 0, 255);
			$pregunta = new Pregunta([
				'user_id' => Auth::user()->id,
				'pregunta' => $request['titulo'],
				'descripcion' => $resumen_pregunta,
				'contenido_html' => $request['contenido_html'],
				'identificador' => $identificador_aleatorio
			]);

			if ($pregunta->save()) {
				return redirect('/pregunta/'.$identificador_aleatorio);
			}
		}
	}

	public function generarIdentificador($cantidad_caracteres) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($cantidad_caracteres/strlen($x)) )),1,$cantidad_caracteres);
	}

	public function mostrar_vista_pregunta($identificador_pregunta) {
		$pregunta = Pregunta::where('identificador', '=', $identificador_pregunta)->get()[0];

		if ($pregunta) {
			return view('auth.mostrar_pregunta', [
				'titulo' => $pregunta['pregunta'],
				'pregunta_encontrada' => true,
				'pregunta_id' => $pregunta['id'],
				'identificador_pregunta' => $identificador_pregunta
			]);
		} else {
			return view('auth.mostrar_pregunta', [
				'titulo' => 'Pregunta no encontrada',
				'pregunta_encontrada' => false,
			]);
		}
	}

	// Obtenemos los datos de la pregunta junto con los comentarios
	public function show($pregunta_id) {
		// Obtenemos la pregunta
		$pregunta = Pregunta::find($pregunta_id);

		// Si la pregunta existe...
		if (isset($pregunta)) {
			// Obtenemos la cantidad de votos positivos de la pregunta
			$votos_positivos = VotoPregunta::where('pregunta_id', '=', $pregunta->id)
			->where('voto_bool', '=', true)
			->count();
			$pregunta['votos_positivos'] = $votos_positivos;

			// Obtenemos la cantidad de votos negativos de la pregunta
			$votos_negativos = VotoPregunta::where('pregunta_id', '=', $pregunta->id)
			->where('voto_bool', '=', false)
			->count();
			$pregunta['votos_negativos'] = $votos_negativos;

			// Verificamos si el usuario autenticado ha votado por la pregunta
			$voto = VotoPregunta::where('pregunta_id', '=', $pregunta->id)
			->where('user_id', '=', Auth::check() ? Auth::user()->id : '')
			->get();

			$ha_votado = 0;
			// Si existe el voto del usuario...
			if (count($voto) > 0) {
				// Verificamos si el voto del usuario es positivo o negativo
				$voto_bool = $voto[0]['voto_bool'];

				if ($voto_bool) {
					$ha_votado = 1;
					$pregunta['ha_votado'] = 1;
				} else {
					if (!$voto_bool) {
						$ha_votado = -1;
						$pregunta['ha_votado'] = -1;
					}
				}
			} else {
				$pregunta['ha_votado'] = 0;
			}

			// Obtenemos los comentario de la pregunta
			$respuestas = Respuesta::where('pregunta_id', '=', $pregunta->id)->get();

			// Recorremos las respuestas
			for ($i=0; $i < count($respuestas); $i++) {
				// Obtenemos el autor de la respuesta
				$autor = User::find($respuestas[$i]['user_id']);
				$autor = $autor->name;
				$respuestas[$i]['autor'] = $autor;
				$respuestas[$i]['ha_votado'] = 0;

				// Obtenemos los votos positivos de la repsuesta
				$votos_positivos = VotoRespuestas::where('respuesta_id', '=', $respuestas[$i]['id'])
				->where('voto_bool', '=', true)
				->get();
				$respuestas[$i]['votos_positivos'] = count($votos_positivos);

				// Obtenemos los votos negativos de la repsuesta
				$votos_negativos = VotoRespuestas::where('respuesta_id', '=', $respuestas[$i]['id'])
				->where('voto_bool', '=', false)
				->get();
				$respuestas[$i]['votos_negativos'] = count($votos_negativos);

				// Verificamos si el usuario votó positivamente o negativamente a la respuesta
				$ha_votado = VotoRespuestas::where('respuesta_id', '=', $respuestas[$i]['id'])
				->where('user_id', '=', Auth::check() ? Auth::user()->id : '')
				->get();

				if (count($ha_votado) > 0) {
					if ($ha_votado[0]['voto_bool'] == false) {
						$respuestas[$i]['ha_votado'] = -1;
					} else {
						if ($ha_votado[0]['voto_bool'] == true) {
							$respuestas[$i]['ha_votado'] = 1;
						}
					}
				} else {
					$respuestas[$i]['ha_votado'] = 0;
				}
			}

			return response()->json([
				'status' => true,
				'pregunta' => $pregunta,
				'ha_votado' => $ha_votado,
				'respuestas' => $respuestas
			]);
		} else {
			return response()->json([
				'status' => false
			]);
		}
	}
}
