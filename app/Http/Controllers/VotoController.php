<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\VotoPregunta;
use App\Models\VotoRespuestas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotoController extends Controller
{
	public function votar_pregunta(Request $request) {
		// Obtenemos...
		$tipoDeVoto = $request['accion']; // Si el voto es positivo o negativo
		$tipoDeItemAVotar = $request['tipo']; // Qué tipo de item vamos a votar
		$ha_votado = 0; // Variable para indicar si el usuario: votó negativamente (-1), no votó (0) ó si es que votó (1)

		// Verificamos si la pregunta existe
		$pregunta = Pregunta::find($request['pregunta_id']);

		// Si la pregunta existe...
		if (isset($pregunta->id)) {
			// Verificamos si el voto existe
			$voto = VotoPregunta::where('user_id', '=', Auth::user()->id)
			->where('pregunta_id', '=', $pregunta->id)
			->get();

			// Si el voto existe...
			if (count($voto) > 0) {
				// Si el voto en la BD es positivo y el usuario vuelve a presionar el botón de positivo de nuevo ó si el voto en la BD es negativo y el usuario vuelve a presionar el botón de negativo de nuevo...
				if (($voto[0]['voto_bool'] == 1 && $tipoDeVoto == 'positivo') || ($voto[0]['voto_bool'] == 0 && $tipoDeVoto == 'negativo')) {
					// Eliminamos el voto
					$voto = VotoPregunta::find($voto[0]['id']);
					$voto->delete();
					$ha_votado = 0;
				} else { // Si el usuario presiona el botón contrario a su voto original...
					// Buscamos el voto, lo modificamos y lo guardamos
					$voto = VotoPregunta::find($voto[0]['id']);
					if ($tipoDeVoto == 'positivo') {
						$voto->voto_bool = true;
						$ha_votado = 1;
					} else {
						if ($tipoDeVoto == 'negativo') {
							$voto->voto_bool = false;
							$ha_votado = -1;
						}
					}
					$voto->save();
				}

				// Obtenemos la cantidad de votos positivos de la pregunta
				$votos_positivos = VotoPregunta::where('pregunta_id', '=', $pregunta->id)
				->where('voto_bool', '=', true)
				->count();

				// Obtenemos la cantidad de votos negativos de la pregunta
				$votos_negativos = VotoPregunta::where('pregunta_id', '=', $pregunta->id)
				->where('voto_bool', '=', false)
				->count();

				// Mandamos una respuesta al front-end
				return response()->json([
					'status' => true,
					'ha_votado' => $ha_votado,
					'votos_positivos' => $votos_positivos,
					'votos_negativos' => $votos_negativos
				]);
			} else { // Si el voto no existe...
				// Si el usuario quiere votar una pregunta...
				if ($tipoDeItemAVotar == 'pregunta') {
					// Creamos el voto
					$voto = new VotoPregunta();
					$voto->user_id = Auth::user()->id;
					$voto->pregunta_id = $pregunta->id;
					if ($tipoDeVoto == 'positivo') {
						$voto->voto_bool = true;
						$ha_votado = 1;
					} else {
						if ($tipoDeVoto == 'negativo') {
							$voto->voto_bool = false;
							$ha_votado = -1;
						}
					}
					$voto->save();

					// Obtenemos la cantidad de votos positivos de la pregunta
					$votos_positivos = VotoPregunta::where('pregunta_id', '=', $pregunta->id)
					->where('voto_bool', '=', true)
					->count();

					// Obtenemos la cantidad de votos negativos de la pregunta
					$votos_negativos = VotoPregunta::where('pregunta_id', '=', $pregunta->id)
					->where('voto_bool', '=', false)
					->count();

					// Mandamos una respuesta al front-end
					return response()->json([
						'status' => true,
						'ha_votado' => $ha_votado,
						'votos_positivos' => $votos_positivos,
						'votos_negativos' => $votos_negativos
					]);
				}
			}
		} else {
			// Mandamos una respuesta indicando que hay un error
			return response()->json([
				'status' => false
			]);
		}
	}

	public function votar_respuesta(Request $request) {
		// Obtenemos...
		$tipoDeVoto = $request['accion']; // Si el voto es positivo o negativo
		$tipoDeItemAVotar = $request['tipo']; // Qué tipo de item vamos a votar
		$ha_votado = 0; // Variable para indicar si el usuario: votó negativamente (-1), no votó (0) ó si es que votó (1)

		// Verificamos si la respuesta existe
		$respuesta = Respuesta::find($request['respuesta_id']);

		// Si la respuesta existe...
		if (isset($respuesta->id)) {
			// Verificamos si el voto existe
			$voto = VotoRespuestas::where('user_id', '=', Auth::user()->id)
			->where('respuesta_id', '=', $respuesta->id)
			->get();

			// Si el voto existe...
			if (count($voto) > 0) {
				// Si el voto en la BD es positivo y el usuario vuelve a presionar el botón de positivo de nuevo ó si el voto en la BD es negativo y el usuario vuelve a presionar el botón de negativo de nuevo...
				if (($voto[0]['voto_bool'] == 1 && $tipoDeVoto == 'positivo') || ($voto[0]['voto_bool'] == 0 && $tipoDeVoto == 'negativo')) {
					// Eliminamos el voto
					$voto = VotoRespuestas::find($voto[0]['id']);
					$voto->delete();
					$ha_votado = 0;
				} else { // Si el usuario presiona el botón contrario a su voto original...
					// Buscamos el voto, lo modificamos y lo guardamos
					$voto = VotoRespuestas::find($voto[0]['id']);
					if ($tipoDeVoto == 'positivo') {
						$voto->voto_bool = true;
						$ha_votado = 1;
					} else {
						if ($tipoDeVoto == 'negativo') {
							$voto->voto_bool = false;
							$ha_votado = -1;
						}
					}
					$voto->save();
				}

				// Obtenemos la cantidad de votos positivos de la respuesta
				$votos_positivos = VotoRespuestas::where('respuesta_id', '=', $respuesta->id)
				->where('voto_bool', '=', true)
				->count();

				// Obtenemos la cantidad de votos negativos de la respuesta
				$votos_negativos = VotoRespuestas::where('respuesta_id', '=', $respuesta->id)
				->where('voto_bool', '=', false)
				->count();

				// Mandamos una respuesta al front-end
				return response()->json([
					'status' => true,
					'ha_votado' => $ha_votado,
					'votos_positivos' => $votos_positivos,
					'votos_negativos' => $votos_negativos
				]);
			} else { // Si el voto no existe...
				// Si el usuario quiere votar una respuesta...
				if ($tipoDeItemAVotar == 'respuesta') {
					// Creamos el voto
					$voto = new VotoRespuestas();
					$voto->user_id = Auth::user()->id;
					$voto->respuesta_id = $respuesta->id;
					if ($tipoDeVoto == 'positivo') {
						$voto->voto_bool = true;
						$ha_votado = 1;
					} else {
						if ($tipoDeVoto == 'negativo') {
							$voto->voto_bool = false;
							$ha_votado = -1;
						}
					}
					$voto->save();

					// Obtenemos la cantidad de votos positivos de la respuesta
					$votos_positivos = VotoRespuestas::where('respuesta_id', '=', $respuesta->id)
					->where('voto_bool', '=', true)
					->count();

					// Obtenemos la cantidad de votos negativos de la respuesta
					$votos_negativos = VotoRespuestas::where('respuesta_id', '=', $respuesta->id)
					->where('voto_bool', '=', false)
					->count();

					// Mandamos una respuesta al front-end
					return response()->json([
						'status' => true,
						'ha_votado' => $ha_votado,
						'votos_positivos' => $votos_positivos,
						'votos_negativos' => $votos_negativos
					]);
				}
			}
		} else {
			// Mandamos una respuesta indicando que hay un error
			return response()->json([
				'status' => false
			]);
		}
	}
}
