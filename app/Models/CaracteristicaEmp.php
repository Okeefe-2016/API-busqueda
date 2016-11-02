<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaracteristicaEmp extends Model
{
    public $table = 'caracteristicaemp';

    public $timestamps = false;

    protected $guarded = ['id_carac'];

    protected $primaryKey = 'id_carac';

    public $fillable = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function emprendimiento_caracteristicas()
    {
        return $this->belongsToMany(EmprendimientoCaracteristica::class, 'id_carac', 'id_carac');
    }
}
