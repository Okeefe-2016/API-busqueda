<?php

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

    public function show($id)
    {
        $emprendimiento = Emprendimiento::with('caracteristicas','properties')->find($id);
        return $emprendimiento;
    }
}