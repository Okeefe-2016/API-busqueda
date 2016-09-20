<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 20/9/16
 * Time: 09:37
 */

namespace App\Http\Controllers\API;


use App\Models\Propiedad;
use InfyOm\Generator\Controller\AppBaseController;

class EmprendimientoAPIController extends AppBaseController
{

    /**
     * @return mixed
     */
    public function index()
    {
        $propiedad = Propiedad::with(['foto', 'propiedad_caracteristicas' => function ($q) {
            $q->select('id_prop_carac', 'id_prop', 'id_carac', 'contenido');
        }, 'propiedad_caracteristicas.caracteristica' => function ($q) {
            $q->select('id_carac', 'id_tipo_carac', 'titulo');
        }])->where('tiene_emprendimiento', 1)->where('destacado', 1)->get();
        
        return $this->sendResponse($propiedad, '');
    }
}