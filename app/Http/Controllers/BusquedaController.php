<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\User;
use App\Models\VotoPregunta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
	public function mostrar_vista_inicio() {
		// Obtenemos las últimas preguntas realizadas por los usuarios
		$cantidad_de_preguntas = 15;

		$preguntas = DB::table('preguntas')
		->orderBy('created_at', 'asc')
		->offset(0)
		->limit($cantidad_de_preguntas)
		->get();
		$preguntas = json_decode($preguntas, true);

		// Recorremos las preguntas
		for ($i=0; $i < count($preguntas); $i++) {
			// Obtenemos el autor de cada pregunta
			$autor = User::find($preguntas[$i]['user_id']);
			$preguntas[$i]['autor'] = $autor->name;

			// Obtenemos la cantidad de votos de cada pregunta
			$votos = VotoPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['votos'] = count($votos) > 0 ? count($votos) : 0;

			// Obtenemos la cantidad de respuestas de cada pregunta
			$respuestas = Respuesta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['respuestas'] = count($respuestas) > 0 ? count($respuestas) : 0;
		}

		return view('inicio', [
			'titulo' => 'DevsOverflow',
			'preguntas' => $preguntas
		]);
	}
	public function mostrar_vista_resultados($query) {
		// Obtenemos el autor de cada pregunta obtenida
		return view('busqueda', [
			'titulo' => 'Resultados de búsqueda',
			'query' => $query,
		]);
	}

	public function realizar_busqueda(Request $request) {
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
					'SELECT p.id, p.pregunta, p.user_id, COALESCE(SUM(vp.voto_bool = 1), 0) AS votos_positivos, COALESCE(SUM(vp.voto_bool = 0), 0) AS votos_negativos
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
			$preguntas[$i]['autor'] = $autor->name;

			// Obtenemos la cantidad de votos de cada pregunta
			$votos = VotoPregunta::where('pregunta_id', '=', $preguntas[$i]['id'])->get();
			$preguntas[$i]['votos'] = count($votos) > 0 ? count($votos) : 0;

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
