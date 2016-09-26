<?php

namespace App\Models;

use Eloquent as Model;

class Emprendimiento extends Model
{
    protected $table = 'emprendimiento';

    protected $primaryKey = 'id_emp';

    /**
     * @return mixed
     */
    public function propiedad()
    {
        return $this->hasMany(Propiedad::class, 'id_emp', 'id_emp');
    }

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

        if (isset($ubicacion)) {
            return $ubicacion->id_ubica;
        }
    }
}