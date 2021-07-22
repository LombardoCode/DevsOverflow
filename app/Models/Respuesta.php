<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
	protected $fillable = ['user_id', 'pregunta_id', 'contenido_html', 'mejor_respuesta'];
	use HasFactory;
}
