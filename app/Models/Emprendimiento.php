<?php

namespace App\Models;

use Eloquent as Model;

class Emprendimiento extends Model
{
    protected $table = 'emprendimiento';

    protected $primaryKey = 'id_emp';

    public function getFotoAttribute()
    {
        return env('PUBLIC_URL') . $this->attributes['foto'];
    }

    /**
     * @return mixed
     */
    public function getIdUbicaAttribute()
    {
        $nombre = $this->nombre;

        $ubicacion = UbicacionPropiedad::where('nombre_ubicacion', $nombre)->first();

        if ($ubicacion->count()) {
            return $ubicacion->id_ubica;
        }
    }
}