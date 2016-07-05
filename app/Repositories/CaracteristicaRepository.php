<?php

namespace App\Repositories;

use App\Models\Caracteristica;
use InfyOm\Generator\Common\BaseRepository;

class CaracteristicaRepository extends BaseRepository
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
        return Caracteristica::class;
    }
}
