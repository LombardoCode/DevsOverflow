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
			return view('mostrar_preguntas_de_categoria', [
				'titulo' => strtolower($nombre_categoria) . ' - Preguntas',
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

	public function show(Request $request) {
		// Obtenemos las categorías seleccionadas en el front-end
		$categorias_seleccionadas = $request['seleccionadas'];

		// Obtenemos los ID's de las categorías seleccionadas en el front-end
		$ids_categorias_seleccionadas = array_column($categorias_seleccionadas, 'id');

		// Obtenemos el input
		$nombre_categoria = $request['input'];

		// Obtenemos las categorías deacuerdo al input y que no se haya seleccionado previamente en el front-end
		$busqueda = Categoria::where('categoria', 'LIKE', '%'.$nombre_categoria.'%')
		->whereNotIn('id', $ids_categorias_seleccionadas)
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
}
