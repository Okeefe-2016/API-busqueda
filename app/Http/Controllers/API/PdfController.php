<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\AppBaseController;

class PdfController extends AppBaseController
{
    public function index(Request $request)
    {
        return "PDF";
    }
    public function store (Request $request){
        //return $request->all();
        //return \PDF::loadView('ruta.vista', $datos)->download('nombre-archivo.pdf');
        $view = 'pdf.property';
        if($request->pdfRoute == 'venture'){
            $view = 'pdf.venture';
        }
        return \PDF::loadView($view,['datos' => $request])->stream('nombre-archivo.pdf');
    }
}
