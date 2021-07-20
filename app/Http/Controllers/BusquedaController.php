<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
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

		// Dependiendo del filtro
		if ($filtro == 'mas_reciente') {
			$preguntas = Pregunta::where('pregunta', 'LIKE', '%'.$query.'%')
			->orderBy('created_at', 'asc')
			->offset($offset)
			->limit($itemsMaxPorPag)
			->get();
		}

		return $preguntas;
	}
}
