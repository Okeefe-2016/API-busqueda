<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 1/9/16
 * Time: 10:57 AM
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\AppBaseController;
use App\Models\UbicacionPropiedad;
use App\Repositories\UbicacionPropiedadRepository;
use App\Repositories\UbicacionRepository;
use Illuminate\Http\Request;

class UbicacionAPIController extends AppBaseController
{
    protected $ubicacion;

    public function __construct(UbicacionRepository $ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    /**
     * @param Request $request
     * @param $zona
     * @param $tipo
     * @param $operacion
     * @return
     */
    public function index(Request $request, $zona, $tipo, $operacion)
    {
        // Validate rural types
        $allowedTypeProp =  in_array($tipo, config('propDefaults.rural.tipo'));

        if ($request->rural && !$allowedTypeProp) {
            return response()->json(['message' => 'Tipo de propiedad rural no valido', 'code' => 401], 401);
        }

        if ($request->emp == 0) {
            $request->emp = " is null";
        } else {
            $request->emp = " is not null";
        }

        $ubications = $this->ubicacion->getByParams($request, $zona, $tipo, $operacion);

        return response($ubications);
    }
}