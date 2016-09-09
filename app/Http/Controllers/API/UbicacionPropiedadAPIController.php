<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Repositories\UbicacionPropiedadRepository;
use Illuminate\Http\Request;

class UbicacionPropiedadAPIController extends AppBaseController
{
    /**
     * @var UbicacionPropiedadRepository
     */
    protected $ubicacionPropiedadRepository;

    /**
     * UbicacionPropiedadController constructor.
     * @param UbicacionPropiedadRepository $ubicacionPropiedadRepository
     */
    public function __construct(UbicacionPropiedadRepository $ubicacionPropiedadRepository)
    {
        $this->ubicacionPropiedadRepository = $ubicacionPropiedadRepository;
    }

    /**
     * Get full results for properties
     *
     * @param Request $request
     * @return mixed
     */
    public function getUbicacionPropiedad(Request $request, $tipo, $operacion)
    {

        if ($request->rural) {
            $allowedTypeProp =  in_array($tipo, config('propDefaults.rural.tipo'));

            if (!$allowedTypeProp) {
                return response()->json(['message' => 'Tipo de propiedad rural no valido', 'code' => 401], 401);
            }
        }

        $params =  ['tipo' => $tipo, 'operacion' => $operacion];

        $result = $this->ubicacionPropiedadRepository
            ->getParentWithChildsQuery($request, $params);

        if ($result) {
            return response()->json(['message' => 'success', 'code' => 200, 'data' => $result]);
        }

    }
}