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
			$preguntas = Pregunta::where('pregunta', 'LIKE', '%'.$query.'%')
			->orderBy('created_at', 'asc')
			->offset($offset)
			->limit($itemsMaxPorPag)
			->get();

			$cantidad_de_preguntas = Pregunta::where('pregunta', 'LIKE', '%'.$query.'%')
			->orderBy('created_at', 'asc')
			->count();

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
		} else {
			if ($filtro == 'votos') {
				$preguntas = DB::table('preguntas')
				->where('pregunta', 'LIKE', '%'.$query.'%')
				->offset($offset)
				->limit($itemsMaxPorPag)
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
			}
		}

		return response()->json([
			'preguntas' => $preguntas,
			'cantidad_de_preguntas' => $cantidad_de_preguntas
		]);
	}
}
