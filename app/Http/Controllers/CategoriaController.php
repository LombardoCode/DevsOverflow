<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Pregunta;
use App\Models\RelacionCategoriaPregunta;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\VotoPregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
	public function mostrar_vista_categorias() {
		return view('mostrar_categorias', [
			'titulo' => 'Crear nueva categoría'
		]);
	}

	public function mostrar_vista_crear_categorias() {
		return view('auth.ajustes.categorias.crear_categoria', [
			'titulo' => 'Crear nueva categoría'
		]);
	}

	public function mostrar_vista_mostrar_categorias() {
		// Obtenemos el usuarios
		return view('auth.ajustes.categorias.mostrar_categorias', [
			'titulo' => 'Categorias'
		]);
	}

	public function mostrar_vista_editar_categoria($categoria_id) {
		// Obtenemos la categoría
		$categoria = Categoria::find($categoria_id);
		return view('auth.ajustes.categorias.editar_categoria', [
			'titulo' => 'Categorias',
			'categoria' => $categoria
		]);
	}

	public function mostrar_vista_preguntas_con_categoria($nombre_categoria) {
		$categoria = Categoria::where('categoria', '=', $nombre_categoria)->get();

		if (isset($categoria[0]['id'])) {
			$preguntas_relacion_a_categoria = RelacionCategoriaPregunta::where('categoria_id', '=', $categoria[0]['id'])->get();

			$preguntas = [];

			// Recorremos todas las relaciones
			for ($i=0; $i < count($preguntas_relacion_a_categoria); $i++) {
				$relacion = $preguntas_relacion_a_categoria[$i];
				$pregunta = Pregunta::find($relacion['pregunta_id']);
				$preguntas[] = $pregunta;
			}

			return view('mostrar_preguntas_de_categoria', [
				'titulo' => strtolower($nombre_categoria) . ' - Preguntas',
				'preguntas' => $preguntas,
				'categoria' => $nombre_categoria
			]);
		} else {
			abort(404);
		}
	}

	public function obtener_categorias(Request $request) {
		$query = $request['query'];
		$itemsMaxPorPag = $request['itemsMaxPorPag'];
		$offset = ((($request['pagina'] + 1) - 1) * $itemsMaxPorPag);
		$cantidad_de_categorias = null;
		$categorias = [];

		$categorias = DB::table('categorias')
		->where('categoria', 'LIKE', '%'.$query.'%')
		->orderBy('created_at', 'asc')
		->offset($offset)
		->limit($itemsMaxPorPag)
		->get();

		$cantidad_de_categorias = DB::table('categorias')
		->where('categoria', 'LIKE', '%'.$query.'%')
		->orderBy('created_at', 'asc')
		->count();

		return response()->json([
			'status' => true,
			'categorias' => $categorias,
			'cantidad_de_categorias' => $cantidad_de_categorias
		]);
	}

	public function store(Request $request) {
		// Reglas de validación de los inputs
		$reglas = [
			'nombre_categoria' => 'required',
			'descripcion_categoria' => 'required'
		];

		// Errores personalizados de la validación de inputs
		$erroresPersonalizados = [
			'nombre_categoria.required' => 'El nombre es obligatorio',
			'descripcion_categoria.required' => 'La descripción es obligatoria'
		];

		// Validamos el formulario
		$validaciones = Validator::make($request->all(), $reglas, $erroresPersonalizados);

		// Si la validación de los inputs falla...
		if ($validaciones->fails()) {
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			// Rellenamos los datos de la categoría
			$categoria = new Categoria();
			$categoria->categoria = $request['nombre_categoria'];
			$categoria->descripcion = $request['descripcion_categoria'];
			if ($categoria->save()) {
				return redirect()->back()->withSuccess('La categoría se ha creado satisfactoriamente.');
			}
		}
	}

	public function show($nombre_categoria) {
		$busqueda = Categoria::where('categoria', 'LIKE', '%'.$nombre_categoria.'%')
		->limit(5)
		->get();
		return response()->json([
			'busqueda' => $busqueda
		]);
	}

	public function delete($id) {
		$categoria = Categoria::find($id);

		if ($categoria->delete()) {
			return response()->json([
				'status' => true
			]);
		} else {
			return response()->json([
				'status' => false
			]);
		}
	}

	public function update(Request $request, $id) {
		// Reglas de validación de los inputs
		$reglas = [
			'nombre_categoria' => 'required',
			'descripcion_categoria' => 'required'
		];

		// Errores personalizados de la validación de inputs
		$erroresPersonalizados = [
			'nombre_categoria.required' => 'El nombre es obligatorio',
			'descripcion_categoria.required' => 'La descripción es obligatoria'
		];

		// Validamos el formulario
		$validaciones = Validator::make($request->all(), $reglas, $erroresPersonalizados);

		// Si la validación de los inputs falla...
		if ($validaciones->fails()) {
			return redirect()->back()->withErrors($validaciones)->withInput();
		} else {
			// Actializamos los datos de la categoría
			$categoria = Categoria::find($id);
			$categoria->categoria = $request['nombre_categoria'];
			$categoria->descripcion = $request['descripcion_categoria'];
			if ($categoria->save()) {
				return redirect()->back()->withSuccess('Los datos de la sucursal fueron editados satisfactoriamente.');
			}
		}
	}

	public function realizar_busqueda(Request $request) {
		$categoria = Categoria::where('categoria', '=', $request['categoria'])->get();
		$filtro = $request['filtro'];
		$itemsMaxPorPag = $request['itemsMaxPorPag'];
		$offset = ((($request['pagina'] + 1) - 1) * $itemsMaxPorPag);
		$preguntas = [];
		$cantidad_de_preguntas = null;

		// Si la categoría existe...
		if (isset($categoria[0]['id'])) {
			// Obtenemos las preguntas más recientes
			if ($filtro == 'mas_reciente') {
				// Obtenemos las preguntas de la categoría solicitada ordenadas de las más recientes hasta las no tan recientes dependiendo del estado de la paginación
				$preguntas_de_categoria = DB::select(
					'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
					FROM preguntas p
					INNER JOIN relacion_categoria_preguntas rcp
					ON p.id = rcp.pregunta_id
					LEFT OUTER JOIN voto_preguntas vp
					ON p.id = vp.pregunta_id
					WHERE rcp.categoria_id = ?
					GROUP BY p.id
					ORDER BY p.created_at DESC
					LIMIT ?
					OFFSET ?;', [$categoria[0]['id'], $itemsMaxPorPag, $offset]);
			} else {
				if ($filtro == 'votos') {
					// Obtenemos las preguntas de la categoría solicitada ordenadas de las más votadas hasta las no tan votadas dependiendo del estado de la paginación
					$preguntas_de_categoria = DB::select(
						'SELECT p.id, p.pregunta, p.user_id, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
						FROM preguntas p
						INNER JOIN relacion_categoria_preguntas rcp
						ON p.id = rcp.pregunta_id
						LEFT OUTER JOIN voto_preguntas vp
						ON p.id = vp.pregunta_id
						WHERE rcp.categoria_id = ?
						GROUP BY p.id
						ORDER BY votos_positivos DESC
						LIMIT ?
						OFFSET ?;', [$categoria[0]['id'], $itemsMaxPorPag, $offset]);
				}
			}

			// Hacemos los resultados accesibles
			$preguntas_de_categoria = json_decode(json_encode($preguntas_de_categoria), true);

			// Obtenemos las preguntas totales de la categoría solicitada
			$cantidad_de_preguntas = DB::select(
				'SELECT COUNT(DISTINCT(p.id)) AS cantidad_de_preguntas
				FROM preguntas p
				INNER JOIN relacion_categoria_preguntas rcp
				ON p.id = rcp.pregunta_id
				LEFT OUTER JOIN voto_preguntas vp
				ON p.id = vp.pregunta_id
				WHERE rcp.categoria_id = ?', [$categoria[0]['id']]);
			$cantidad_de_preguntas = json_decode(json_encode($cantidad_de_preguntas), true);
			$cantidad_de_preguntas = $cantidad_de_preguntas[0]['cantidad_de_preguntas'];

			// Recorremos las relaciones de pregunta-categoria
			for ($i=0; $i < count($preguntas_de_categoria); $i++) {
				// Obtenemos la pregunta
				$pregunta = Pregunta::find($preguntas_de_categoria[$i]['id']);
				$preguntas[$i] = $pregunta;

				// Obtenemos el autor de cada pregunta
				$autor = User::find($pregunta['user_id']);
				$preguntas[$i]['autor'] = $autor->name;

				// Obtenemos la cantidad de votos de cada pregunta
				$votos = VotoPregunta::where('pregunta_id', '=', $pregunta['id'])->get();
				$preguntas[$i]['votos'] = count($votos) > 0 ? count($votos) : 0;

				// Obtenemos la cantidad de respuestas de cada pregunta
				$respuestas = Respuesta::where('pregunta_id', '=', $pregunta['id'])->get();
				$preguntas[$i]['respuestas'] = count($respuestas) > 0 ? count($respuestas) : 0;
			}

			return response()->json([
				'preguntas' => $preguntas,
				'cantidad_de_preguntas' => $cantidad_de_preguntas
			]);
		}
	}
}
