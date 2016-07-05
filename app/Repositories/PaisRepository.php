<?php

namespace App\Repositories;

use App\Models\Pais;
use InfyOm\Generator\Common\BaseRepository;

class PaisRepository extends BaseRepository
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
        return Pais::class;
    }
}
