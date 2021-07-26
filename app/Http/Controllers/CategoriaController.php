<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
	public function show($nombre_categoria) {
		$busqueda = Categoria::where('categoria', 'LIKE', '%'.$nombre_categoria.'%')->get();
		return response()->json([
			'busqueda' => $busqueda
		]);
	}
}
