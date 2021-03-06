<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreatePropiedadesRequest;
use App\Http\Requests\UpdatePropiedadesRequest;
use App\Models\Propiedad;
use App\Models\UbicacionPropiedad;
use App\Repositories\PropiedadRepository;
use App\Repositories\UbicacionPropiedadRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PropiedadesController extends AppBaseController
{
    /** @var  PropiedadesRepository */
    private $propiedadesRepository;

    public function __construct(PropiedadRepository $propiedadesRepo)
    {
        $this->propiedadesRepository = $propiedadesRepo;
    }

    /**
     * Display the specified Propiedades.
     *
     * @param  int $id
     * @param UbicacionPropiedadRepository $ubica
     * @return Response
     */
    public function show($id, UbicacionPropiedadRepository $ubica)
    {
        $propiedad = $this->propiedadesRepository->getWithUbication($id, $ubica);

        return $propiedad;
    }
}
