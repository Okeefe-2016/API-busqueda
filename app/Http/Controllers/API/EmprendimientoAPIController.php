<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 20/9/16
 * Time: 09:37
 */

namespace App\Http\Controllers\API;


use App\Models\Emprendimiento;
use App\Models\Propiedad;
use InfyOm\Generator\Controller\AppBaseController;

class EmprendimientoAPIController extends AppBaseController
{

    /**
     * @return mixed
     */
    public function index()
    {
        $emprendimiento = Emprendimiento::all();

        return $emprendimiento;
    }
}