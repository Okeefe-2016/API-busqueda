<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 13/6/16
 * Time: 1:54 PM
 */

namespace App\Models;

use Eloquent as Model;

class PropiedadCaracteristica extends Model
{
    protected $table = 'propiedad_caracteristicas';

    public $primaryKey = 'id_prop';
    
    public function propiedad()
    {
        return $this->belognsTo(Propiedad::class);
    }

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'id_carac', 'id_carac');
    }
}