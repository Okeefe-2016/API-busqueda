<?php

namespace App\Repositories;

use App\Models\Domicilio;
use InfyOm\Generator\Common\BaseRepository;

class DomicilioRepository extends BaseRepository
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
        return Domicilio::class;
    }
}
