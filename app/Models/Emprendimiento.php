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

    public function properties()
    {
        return $this->hasMany(Propiedad::class, 'id_emp', 'id_emp')
            ->select('id_prop','activa','calle','destacado','goglat','goglong','id_tipo_prop','id_ubica'
                ,'id_emp','oportunidad','subtipo_prop','tipo_oper_id')
            ->with(['ubicacion','propiedad_caracteristicas' => function ($query) {
                $query->selectRaw('id_prop,id_carac, contenido')
                    ->whereIn('id_carac', [71, 373, 374, 198, 255, 257, 208, 161, 166, 165, 164, 198]);
            }, 'foto' => function ($query) {
                $query->selectRaw('id_prop,foto as foto_principal')
                    ->where('posicion', 1);
            }]);
    }

    public function caracteristicas()
    {
        return $this->hasMany(EmprendimientoCaracteristica::class, 'id_emp');
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