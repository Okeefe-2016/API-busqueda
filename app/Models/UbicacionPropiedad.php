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
                    ->whereIn('id_carac', [71, 373, 374, 198, 255, 257, 208, 161, 166, 165, 164, 303]);
            }, 'foto' => function ($query) {
                $query->selectRaw('id_prop,foto as foto_principal')
                    ->where('posicion', 1);
            }]);
    }

    public function getNombreCompletoAttribute($value)
    {
        $name = $this->attributes['nombre_ubicacion'];
        if($this->attributes['id_padre']){
            $ubic = UbicacionPropiedad::where('id_ubica', $this->attributes['id_padre'])->first();
            $name = $ubic->nombre_ubicacion.', '.$name;
            if($ubic->id_padre){
                $ubicp = UbicacionPropiedad::where('id_ubica', $ubic->id_padre)->first();
                $name = $ubicp->nombre_ubicacion.', '.$name;
                if($ubicp->id_padre){
                    $ubicb = UbicacionPropiedad::where('id_ubica', $ubicp->id_padre)->first();
                    $name = $ubicb->nombre_ubicacion.', '.$name;
                }
            }
        }
        return $name;
    }

    public function childUbication()
    {
        return $this->hasMany(UbicacionPropiedad::class, 'id_padre', 'id_ubica');
    }

}