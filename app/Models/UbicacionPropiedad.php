<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionPropiedad extends Model
{
    protected $table = 'ubicacionpropiedad';

    protected $primaryKey = 'id_ubica';

    public $timestamps = false;


    /**
     * The properties that belong to the ubication.
     */
    public function propertiesCount()
    {
        return $this->hasOne(Propiedad::class, 'id_ubica', 'id_ubica')
            ->selectRaw('id_ubica, count(*) as count')->groupBy('id_ubica');
    }

    public function properties()
    {
        return $this->hasMany(Propiedad::class, 'id_ubica', 'id_ubica')
            ->select('id_prop','activa','calle','destacado','goglat','goglong','id_tipo_prop','id_ubica'
                ,'id_emp','oportunidad','subtipo_prop','tipo_oper_id')
            ->with(['propiedad_caracteristicas' => function ($query) {
                $query->selectRaw('id_prop,id_carac, contenido')
                    ->whereIn('id_carac', [71, 373, 374, 198, 255, 257, 208, 161, 166, 165, 164]);
            }, 'foto' => function ($query) {
                $query->selectRaw('id_prop,foto as foto_principal')
                    ->where('posicion', 1);
            }]);
    }

    public function childUbication()
    {
        return $this->hasMany(UbicacionPropiedad::class, 'id_padre', 'id_ubica');
    }

}