<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PdfController extends Controller
{
    public function github (Request $request){
        //return $request->all();
        //return \PDF::loadView('ruta.vista', $datos)->download('nombre-archivo.pdf');
        return \PDF::loadView('pdf.property',['datos' => $request])->stream('nombre-archivo.pdf');
    }
}
