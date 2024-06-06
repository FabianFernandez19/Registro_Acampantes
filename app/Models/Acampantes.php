<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acampantes extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_entrada',
        'cargo',
        'nombre_completo',
        'email',
        'tipo_sangre',
        'tipo_documento_identificacion',
        'numero_identificacion',
        'fecha_nacimiento',
        'fecha_ingreso_club',
        'telefono',
        'direccion',
        'Edad',
        'eps_afiliada',
        'alergico',
        'medicamento_alergias',
        'enfermedades_cronicas',
        'medicamento_enfermedades_cronicas',
        'en_caso_de_accidente_avisar_a',
        'relacion_persona_de_contacto',
        'telefono_persona_contacto',
        'club_id'
        

    ];

   // public $table = 'acampantes';

    protected $table = 'acampantes';

    public function club() {
        return $this->belongsTo(Clubes::class, 'club_id');
    }



}
