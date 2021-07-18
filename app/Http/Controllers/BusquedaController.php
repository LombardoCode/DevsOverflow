<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
	public function realizar_busqueda($query) {
		$preguntas = Pregunta::where('pregunta', 'like', '%'.$query.'%')->get();
		return view('busqueda', [
			'titulo' => 'Resultados de búsqueda',
			'query' => $query,
			'preguntas' => $preguntas
		]);
	}
}
