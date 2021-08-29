<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Pregunta;
use App\Models\RelacionCategoriaPregunta;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\VotoPregunta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
	public function mostrar_vista_inicio() {
		return view('inicio', [
			'titulo' => 'DevsOverflow'
		]);
	}

	public function mostrar_vista_resultados($query) {
		// Obtenemos el autor de cada pregunta obtenida
		return view('busqueda', [
			'titulo' => 'Resultados de búsqueda',
			'query' => $query,
		]);
	}

	public function mostrar_vista_preguntas_sin_responder() {
		return view('preguntas_sin_responder', [
			'titulo' => 'Preguntas sin responder'
		]);
	}

	public function realizar_busqueda(Request $request) {
		// Si la búsqueda fué realizada mediante una barra de búsqueda...
		if ($request['query'] == null && $request['todas'] == true) {
			$request['query'] = "";
			return $this->realizar_busqueda_mediante_query($request);
		}

		if (isset($request['query']) && $request['query'] != null) {
			return $this->realizar_busqueda_mediante_query($request);
		}
		// Para obtener las preguntas sin respuestas
		if ($request['sin_responder'] == true) {
			return $this->realizar_busqueda_sin_responder($request);
		}
		// Para obtener las preguntas de categoría
		if (isset($request['categoria']) && $request['categoria'] != null) {
			return $this->realizar_busqueda_mediante_categoria($request);
		}
		// Para obtener las preguntas propias del usuario
		if ($request['preguntas_propias'] == true) {
			return $this->realizar_busqueda_preguntas_propias($request);
		}
	}

	public function realizar_busqueda_mediante_query(Request $request) {
		$filtro = $request['filtro'];
		$itemsMaxPorPag = $request['itemsMaxPorPag'];
		$offset = ((($request['pagina'] + 1) - 1) * $itemsMaxPorPag);
		$query = $request['query'];
		$preguntas = [];
		$cantidad_de_preguntas = null;

		// Obtenemos las preguntas más recientes
		if ($filtro == 'mas_reciente') {
				// Obtenemos las preguntas siguiendo el query y ordenadas de las más recientes hasta las no tan recientes dependiendo del estado de la paginación
			$preguntas = DB::select(
				'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
				FROM preguntas p
				LEFT OUTER JOIN voto_preguntas vp
				ON p.id = vp.pregunta_id
				WHERE p.pregunta LIKE "%'.$query. '%"
				GROUP BY p.id
				ORDER BY p.created_at DESC
				LIMIT ?
				OFFSET ?;', [$itemsMaxPorPag, $offset]);
		} else {
			if ($filtro == 'votos') {
				// Obtenemos las preguntas siguiendo el query y ordenadas de las más votadas hasta las no tan votadas dependiendo del estado de la paginación
				$preguntas = DB::select(
					'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
					FROM preguntas p
					LEFT OUTER JOIN voto_preguntas vp
					ON p.id = vp.pregunta_id
					WHERE p.pregunta LIKE "%'.$query. '%"
					GROUP BY p.id
					ORDER BY votos_positivos DESC
					LIMIT ?
					OFFSET ?;', [$itemsMaxPorPag, $offset]);
			}
		}

		// Hacemos los resultados accesibles
		$preguntas = json_decode(json_encode($preguntas), true);

		// Obtenemos las preguntas totales
		$cantidad_de_preguntas = DB::select(
			'SELECT COUNT(DISTINCT(p.id)) AS cantidad_de_preguntas
			FROM preguntas p
			WHERE p.pregunta LIKE "%'.$query. '%"', []);
		$cantidad_de_preguntas = json_decode(json_encode($cantidad_de_preguntas), true);
		$cantidad_de_preguntas = $cantidad_de_preguntas[0]['cantidad_de_preguntas'];

		// Recorremos las preguntas
		for ($i=0; $i < count($preguntas); $i++) {
			// Obtenemos el autor de cada pregunta
			$autor = User::find($preguntas[$i]['user_id']);
			$preguntas[$i]['autor']['id'] = $autor->id;
			$preguntas[$i]['autor']['nombre'] = $autor->name;

			// Obtenemos la cantidad de votos de cada pregunta
			$votos = VotoPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['votos'] = count($votos) > 0 ? count($votos) : 0;

			// Formateamos la fecha de creación
			$preguntas[$i]['created_at'] = Carbon::parse($preguntas[$i]['created_at'])->diffForHumans();

			// Obtenemos las categorías de la pregunta
			$relacion_categorias = RelacionCategoriaPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();

			// Recorremos las relaciones
			for ($j=0; $j < count($relacion_categorias); $j++) {
				// Obtenemos la categoría
				$categoria = Categoria::find($relacion_categorias[$j]['categoria_id']);

				// Adjuntamos la categoría a la pregunta
				$preguntas[$i]['categorias'][] = $categoria;
			}

			// Obtenemos la cantidad de respuestas de cada pregunta
			$respuestas = Respuesta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['respuestas'] = count($respuestas) > 0 ? count($respuestas) : 0;
		}

		return response()->json([
			'preguntas' => $preguntas,
			'cantidad_de_preguntas' => $cantidad_de_preguntas
		]);
	}

	public function realizar_busqueda_sin_responder(Request $request) {
		$filtro = $request['filtro'];
		$itemsMaxPorPag = $request['itemsMaxPorPag'];
		$offset = ((($request['pagina'] + 1) - 1) * $itemsMaxPorPag);
		$query = $request['query'];
		$preguntas = [];
		$cantidad_de_preguntas = null;

		// Obtenemos las preguntas más recientes
		if ($filtro == 'mas_reciente') {
				// Obtenemos las preguntas siguiendo el query y ordenadas de las más recientes hasta las no tan recientes dependiendo del estado de la paginación
			$preguntas = DB::select(
				'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
				FROM preguntas p
				LEFT OUTER JOIN voto_preguntas vp
				ON p.id = vp.pregunta_id
				WHERE p.id NOT IN (
						SELECT r.pregunta_id
						FROM respuestas r
				)
				GROUP BY p.id
				ORDER BY p.created_at DESC
				LIMIT ?
				OFFSET ?;', [$itemsMaxPorPag, $offset]);
		} else {
			if ($filtro == 'votos') {
				// Obtenemos las preguntas siguiendo el query y ordenadas de las más votadas hasta las no tan votadas dependiendo del estado de la paginación
				$preguntas = DB::select(
					'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
					FROM preguntas p
					LEFT OUTER JOIN voto_preguntas vp
					ON p.id = vp.pregunta_id
					WHERE p.id NOT IN (
							SELECT r.pregunta_id
							FROM respuestas r
					)
					GROUP BY p.id
					ORDER BY votos_positivos DESC
					LIMIT ?
					OFFSET ?;', [$itemsMaxPorPag, $offset]);
			}
		}

		// Hacemos los resultados accesibles
		$preguntas = json_decode(json_encode($preguntas), true);

		// Obtenemos las preguntas totales
		$cantidad_de_preguntas = DB::select(
			'SELECT COUNT(DISTINCT(p.id)) AS cantidad_de_preguntas
			FROM preguntas p
			LEFT OUTER JOIN voto_preguntas vp
			ON p.id = vp.pregunta_id
			WHERE p.id NOT IN (
					SELECT r.pregunta_id
					FROM respuestas r
			)
			ORDER BY p.created_at DESC;', []);
		$cantidad_de_preguntas = json_decode(json_encode($cantidad_de_preguntas), true);
		$cantidad_de_preguntas = $cantidad_de_preguntas[0]['cantidad_de_preguntas'];

		// Recorremos las preguntas
		for ($i=0; $i < count($preguntas); $i++) {
			// Obtenemos el autor de cada pregunta
			$autor = User::find($preguntas[$i]['user_id']);
			$preguntas[$i]['autor']['id'] = $autor->id;
			$preguntas[$i]['autor']['nombre'] = $autor->name;

			// Obtenemos la cantidad de votos de cada pregunta
			$votos = VotoPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['votos'] = count($votos) > 0 ? count($votos) : 0;

			// Formateamos la fecha de creación
			$preguntas[$i]['created_at'] = Carbon::parse($preguntas[$i]['created_at'])->diffForHumans();

			// Obtenemos las categorías de la pregunta
			$relacion_categorias = RelacionCategoriaPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();

			// Recorremos las relaciones
			for ($j=0; $j < count($relacion_categorias); $j++) {
				// Obtenemos la categoría
				$categoria = Categoria::find($relacion_categorias[$j]['categoria_id']);

				// Adjuntamos la categoría a la pregunta
				$preguntas[$i]['categorias'][] = $categoria;
			}

			// Obtenemos la cantidad de respuestas de cada pregunta
			$respuestas = Respuesta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['respuestas'] = count($respuestas) > 0 ? count($respuestas) : 0;
		}

		return response()->json([
			'preguntas' => $preguntas,
			'cantidad_de_preguntas' => $cantidad_de_preguntas
		]);
	}

	public function realizar_busqueda_mediante_categoria(Request $request) {
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
				$preguntas = DB::select(
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
					$preguntas = DB::select(
						'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
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
			$preguntas = json_decode(json_encode($preguntas), true);

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
			for ($i=0; $i < count($preguntas); $i++) {
				// Obtenemos el autor de cada pregunta
				$autor = User::find($preguntas[$i]['user_id']);
				$preguntas[$i]['autor']['id'] = $autor->id;
				$preguntas[$i]['autor']['nombre'] = $autor->name;

				// Obtenemos la cantidad de votos de cada pregunta
				$votos = VotoPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
				$preguntas[$i]['votos'] = count($votos) > 0 ? count($votos) : 0;

				// Formateamos la fecha de creación
				$preguntas[$i]['created_at'] = Carbon::parse($preguntas[$i]['created_at'])->diffForHumans();

				// Obtenemos las categorías de la pregunta
				$relacion_categorias = RelacionCategoriaPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();

				// Recorremos las relaciones
				for ($j=0; $j < count($relacion_categorias); $j++) {
					// Obtenemos la categoría
					$categoria = Categoria::find($relacion_categorias[$j]['categoria_id']);

					// Adjuntamos la categoría a la pregunta
					$preguntas[$i]['categorias'][] = $categoria;
				}

				// Obtenemos la cantidad de respuestas de cada pregunta
				$respuestas = Respuesta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
				$preguntas[$i]['respuestas'] = count($respuestas) > 0 ? count($respuestas) : 0;
			}

			return response()->json([
				'preguntas' => $preguntas,
				'cantidad_de_preguntas' => $cantidad_de_preguntas
			]);
		}
	}

	public function realizar_busqueda_preguntas_propias(Request $request) {
		$filtro = $request['filtro'];
		$itemsMaxPorPag = $request['itemsMaxPorPag'];
		$offset = ((($request['pagina'] + 1) - 1) * $itemsMaxPorPag);
		$query = $request['query'];
		$preguntas = [];
		$cantidad_de_preguntas = null;

		// Obtenemos las preguntas más recientes
		if ($filtro == 'mas_reciente') {
				// Obtenemos las preguntas siguiendo el query y ordenadas de las más recientes hasta las no tan recientes dependiendo del estado de la paginación
			$preguntas = DB::select(
				'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
				FROM preguntas p
				LEFT OUTER JOIN voto_preguntas vp
				ON p.id = vp.pregunta_id
				WHERE p.pregunta LIKE "%'.$query. '%"
				AND p.user_id = ?
				GROUP BY p.id
				ORDER BY p.created_at DESC
				LIMIT ?
				OFFSET ?;', [Auth::user()->id, $itemsMaxPorPag, $offset]);
		} else {
			if ($filtro == 'votos') {
				// Obtenemos las preguntas siguiendo el query y ordenadas de las más votadas hasta las no tan votadas dependiendo del estado de la paginación
				$preguntas = DB::select(
					'SELECT p.*, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
					FROM preguntas p
					LEFT OUTER JOIN voto_preguntas vp
					ON p.id = vp.pregunta_id
					WHERE p.pregunta LIKE "%'.$query. '%"
					AND p.user_id = ?
					GROUP BY p.id
					ORDER BY votos_positivos DESC
					LIMIT ?
					OFFSET ?;', [Auth::user()->id, $itemsMaxPorPag, $offset]);
			}
		}

		// Hacemos los resultados accesibles
		$preguntas = json_decode(json_encode($preguntas), true);

		// Obtenemos las preguntas totales
		$cantidad_de_preguntas = DB::select(
			'SELECT COUNT(DISTINCT(p.id)) AS cantidad_de_preguntas
			FROM preguntas p
			WHERE p.pregunta LIKE "%'.$query. '%" AND p.user_id = ?', [Auth::user()->id]);
		$cantidad_de_preguntas = json_decode(json_encode($cantidad_de_preguntas), true);
		$cantidad_de_preguntas = $cantidad_de_preguntas[0]['cantidad_de_preguntas'];

		// Recorremos las preguntas
		for ($i=0; $i < count($preguntas); $i++) {
			// Obtenemos el autor de cada pregunta
			$autor = User::find($preguntas[$i]['user_id']);
			$preguntas[$i]['autor']['id'] = $autor->id;
			$preguntas[$i]['autor']['nombre'] = $autor->name;

			// Obtenemos la cantidad de votos de cada pregunta
			$votos = VotoPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['votos'] = count($votos) > 0 ? count($votos) : 0;

			// Formateamos la fecha de creación
			$preguntas[$i]['created_at'] = Carbon::parse($preguntas[$i]['created_at'])->diffForHumans();

			// Obtenemos las categorías de la pregunta
			$relacion_categorias = RelacionCategoriaPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();

			// Recorremos las relaciones
			for ($j=0; $j < count($relacion_categorias); $j++) {
				// Obtenemos la categoría
				$categoria = Categoria::find($relacion_categorias[$j]['categoria_id']);

				// Adjuntamos la categoría a la pregunta
				$preguntas[$i]['categorias'][] = $categoria;
			}

			// Obtenemos la cantidad de respuestas de cada pregunta
			$respuestas = Respuesta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['respuestas'] = count($respuestas) > 0 ? count($respuestas) : 0;
		}

		return response()->json([
			'preguntas' => $preguntas,
			'cantidad_de_preguntas' => $cantidad_de_preguntas
		]);
	}
}
