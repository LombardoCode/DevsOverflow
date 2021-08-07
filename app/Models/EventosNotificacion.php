<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosNotificacion extends Model
{
    use HasFactory;
		protected $table = 'eventos_notificaciones';
		protected $fillable = ['evento'];
}
