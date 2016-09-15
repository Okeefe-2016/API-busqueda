<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Propiedad;
use App\Repositories\PropiedadRepository;
use App\Repositories\UbicacionPropiedadRepository;

class SuggestedAPIController extends AppBaseController
{

    protected $repo;

    public function __construct(PropiedadRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param $id
     * @param UbicacionPropiedadRepository $ubica
     * @return
     */
    public function show($id, UbicacionPropiedadRepository $ubica)
    {
        $props = $this->repo->getSimilar($id, $ubica);

        if (!$props->count()) {
            return response()->json([]);
        }

        return response()->json($props);
    }
}