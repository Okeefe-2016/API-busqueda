<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmprendimientoCaracteristica extends Model
{
    protected $table = 'emprendimiento_caracteristicas';

    public $primaryKey = 'id_emp';

    public function emprendimiento()
    {
        return $this->belognsTo(Emprendimiento::class);
    }

    public function caracteristica()
    {
        return $this->belongsTo(CaracteristicaEmp::class, 'id_carac', 'id_carac');
    }
}
