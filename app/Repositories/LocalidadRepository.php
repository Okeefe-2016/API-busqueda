<?php

namespace App\Repositories;

use App\Models\Localidad;
use InfyOm\Generator\Common\BaseRepository;

class LocalidadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Localidad::class;
    }
}
