<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\AppBaseController;

class PdfController extends AppBaseController
{
    public function propertypdf (Request $request){
        //return $request->all();
        //return \PDF::loadView('ruta.vista', $datos)->download('nombre-archivo.pdf');
        return \PDF::loadView('pdf.property',['datos' => $request])->stream('nombre-archivo.pdf');
    }
}
