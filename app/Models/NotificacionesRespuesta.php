<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionesRespuesta extends Model
{
    use HasFactory;
		protected $fillable = ['usuario_causante_id', 'pregunta_id', 'notificacion_id'];
}
