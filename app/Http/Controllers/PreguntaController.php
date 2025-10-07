<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Pregunta;
use App\Models\RelacionCategoriaPregunta;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\VotoPregunta;
use App\Models\VotoRespuestas;
use ArrayObject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PreguntaController extends Controller
{
	public function mostrar_vista_crear_pregunta() {
		return view('auth.crear_y_editar_pregunta', [
			'titulo' => 'Crear pregunta'
		]);
	}

	public function mostrar_vista_mis_preguntas() {
		return view('auth.mi_actividad.mis_preguntas', [
			'titulo' => 'Crear pregunta'
		]);
	}

	public function mostrar_vista_editar_pregunta($identificador_pregunta) {
		$pregunta = Pregunta::where('identificador', '=', $identificador_pregunta)->get();
		$pregunta = json_decode($pregunta, true);

		if (isset($pregunta[0]['id'])) {
			$pregunta = $pregunta[0];

			// Obtenemos las categorías de la pregunta
			$relacion_categorias = RelacionCategoriaPregunta::where('pregunta_id', '=', $pregunta['id'])->get();

			// Recorremos las relaciones de categoría
			for ($i=0; $i < count($relacion_categorias); $i++) {
				$categoria = Categoria::find($relacion_categorias[$i]['categoria_id']);
				$pregunta['categorias'][] = $categoria;
			}

			return view('auth.crear_y_editar_pregunta', [
				'titulo' => 'Editar pregunta',
				'pregunta' => $pregunta,
				'editar' => true
			]);
		} else {
			return abort(404);
		}
	}

	public function mostrar_vista_eliminar_pregunta($identificador_pregunta) {
		return $identificador_pregunta;
	}

	public function store(Request $request) {
		$datosAEvaluar = [];
		$datosAEvaluar['titulo'] = $request['formulario']['titulo'];
		$datosAEvaluar['contenido_html'] = $request['formulario']['contenido_html'];
		$datosAEvaluar['categorias_seleccionadas'] = $request['categorias_seleccionadas'];

		$reglas = [
			'titulo' => 'required',
			'contenido_html' => 'required',
			'categorias_seleccionadas' => 'required'
		];

		$erroresPersonalizados = [
			'titulo.required' => 'Se requiere de un título para la pregunta.',
			'contenido_html.required' => 'Se requiere del cuerpo de la pregunta',
			'categorias_seleccionadas.required' => 'Se requiere al menos una categoría para la pregunta'
		];

		$validaciones = Validator::make($datosAEvaluar, $reglas, $erroresPersonalizados);

		if ($validaciones->fails()) {
			return response()->json([
				'status' => false,
				'errores' => $validaciones->errors()
			]);
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			// Creamos la pregunta y la guardamos
			$identificador_aleatorio = $this->generarIdentificador(16);
			$resumen_pregunta = strip_tags($datosAEvaluar['contenido_html']);
			$resumen_pregunta = substr($resumen_pregunta, 0, 255);
			$pregunta = new Pregunta([
				'user_id' => Auth::user()->id,
				'pregunta' => $datosAEvaluar['titulo'],
				'descripcion' => $resumen_pregunta,
				'contenido_html' => $datosAEvaluar['contenido_html'],
				'identificador' => $identificador_aleatorio
			]);
			$pregunta->save();

			// Relacionamos la pregunta con sus categorias elegidas
			for ($i=0; $i < count($datosAEvaluar['categorias_seleccionadas']); $i++) {
				// Obtenemos la categoría
				$categoria = $datosAEvaluar['categorias_seleccionadas'][$i];

				// Creamos la relación de la categoría con la pregunta
				$relacion_categoria_pregunta = new RelacionCategoriaPregunta();
				$relacion_categoria_pregunta->categoria_id = $categoria['id'];
				$relacion_categoria_pregunta->pregunta_id = $pregunta->id;
				$relacion_categoria_pregunta->save();
			}

			return response()->json([
				'status' => true,
				'identificador' => $identificador_aleatorio
			]);
		}
	}

	public function update(Request $request, $pregunta_id) {
		$datosAEvaluar = [];
		$datosAEvaluar['titulo'] = $request['formulario']['titulo'];
		$datosAEvaluar['contenido_html'] = $request['formulario']['contenido_html'];
		$datosAEvaluar['categorias_seleccionadas'] = $request['categorias_seleccionadas'];

		$reglas = [
			'titulo' => 'required',
			'contenido_html' => 'required',
			'categorias_seleccionadas' => 'required'
		];

		$erroresPersonalizados = [
			'titulo.required' => 'Se requiere de un título para la pregunta.',
			'contenido_html.required' => 'Se requiere del cuerpo de la pregunta',
			'categorias_seleccionadas.required' => 'Se requiere al menos una categoría para la pregunta'
		];

		$validaciones = Validator::make($datosAEvaluar, $reglas, $erroresPersonalizados);

		if ($validaciones->fails()) {
			return response()->json([
				'status' => false,
				'errores' => $validaciones->errors()
			]);
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			// Obtenemos la pregunta
			$pregunta = Pregunta::find($pregunta_id);

			// Editamos la pregunta y la guardamos
			$resumen_pregunta = strip_tags($datosAEvaluar['contenido_html']);
			$resumen_pregunta = substr($resumen_pregunta, 0, 255);
			$pregunta->pregunta = $datosAEvaluar['titulo'];
			$pregunta->descripcion = $resumen_pregunta;
			$pregunta->contenido_html = $datosAEvaluar['contenido_html'];
			$pregunta->save();

			// Eliminamos las relaciones actuales
			$categorias_pregunta = RelacionCategoriaPregunta::where('pregunta_id', '=', $pregunta_id)->delete();

			// Relacionamos la pregunta con sus categorias elegidas
			for ($i=0; $i < count($datosAEvaluar['categorias_seleccionadas']); $i++) {
				// Obtenemos la categoría
				$categoria = $datosAEvaluar['categorias_seleccionadas'][$i];

				// Creamos la relación de la categoría con la pregunta
				$relacion_categoria_pregunta = new RelacionCategoriaPregunta();
				$relacion_categoria_pregunta->categoria_id = $categoria['id'];
				$relacion_categoria_pregunta->pregunta_id = $pregunta->id;
				$relacion_categoria_pregunta->save();
			}

			return response()->json([
				'status' => true,
				'identificador' => $pregunta->identificador
			]);
		}
	}

	public function delete($id_pregunta) {
		$pregunta = Pregunta::find($id_pregunta);

		if ($pregunta->delete()) {
			return response()->json([
				'status' => true
			]);
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
			// Obtenemos las categorías de la pregunta
			$categorias = [];
			$relacion_categoria_pregunta = RelacionCategoriaPregunta::where('pregunta_id', '=', $pregunta->id)->get();

			// Recorremos las categorías de la pregunta
			for ($i=0; $i < count($relacion_categoria_pregunta); $i++) {
				$relacion = $relacion_categoria_pregunta[$i];
				$categoria = Categoria::find($relacion->categoria_id);
				$categorias[] = strtolower($categoria->categoria);
			}

			// Obtenemos el autor de la pregunta
			$autor = User::find($pregunta->user_id);

			// Obtenemos las categorías
			$pregunta['categorias'] = $categorias;

			// Formateamos la fecha de creación
			$pregunta->fecha_de_creacion = Carbon::parse($pregunta->created_at)->diffForHumans();

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
			$respuestas = Respuesta::where('pregunta_id', '=', $pregunta->id)
			->orderBy('created_at', 'DESC')
			->get();
			$respuestas = json_decode(json_encode($respuestas), true);

			// Recorremos las respuestas
			for ($i=0; $i < count($respuestas); $i++) {
				// Obtenemos el autor de la respuesta
				$autor_respuesta = User::find($respuestas[$i]['user_id']);
				$respuestas[$i]['autor']['id'] = $autor_respuesta->id;
				$respuestas[$i]['autor']['nombre'] = $autor_respuesta->name;
				$respuestas[$i]['ha_votado'] = 0;

				// Formateamos la fecha de creación
				$respuestas[$i]['created_at'] = Carbon::parse($respuestas[$i]['created_at'])->diffForHumans();

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
				'autor' => $autor,
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
