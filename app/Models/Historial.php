<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Historial extends Model
{
    use HasFactory;
    protected $table        = "historial";
    protected $connection   = 'mysql';

    protected $fillable = [
        'id',
        'id_usuario',
        'id_paciente',
        'fecha',
        'hora',
        'consecutivo',
        'estado',
        'informacion_antecedentes',
        'evolucion_final',
        'concepto_profesional',
        'recomendaciones',
        'id_firma',
        'estado_firma'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function paciente()
    {
        return $this->belongsTo(User::class, 'id_paciente');
    }
}
