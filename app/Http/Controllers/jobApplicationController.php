<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;

class jobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('\Barryvdh\Cors\HandleCors::class');
    }

    public function index(Request $request)
    {
        return "API";
    }


    public function show(Request $request, $user_id, $id)
    {
        //
    }


    public function store(Request $request)
    {
        //return $request->file->getClientOriginalName();
        return Mail::send('emails.jobApp',['data'=> $request], function($message) use ($request) {
            $message->from('admin@okeefe.com.ar', 'Sitio Okeefe');
            //$message->to('juancruz@okeefe.com.ar')->subject('Nuevo aplicante  a través de www.okeefe.com.ar');
            //$message->to('lucia@lyncros.com')->subject('Nuevo aplicante  a través de www.okeefe.com.ar');
            $message->to('sebasnavarrete.2@gmail.com')->subject('Nuevo aplicante  a través de www.okeefe.com.ar');
            if ($request->hasFile('file')) {
                $message->attach($request->file->getRealPath(), array(
                        'as' => $request->file->getClientOriginalName().'.'.$request->file->getClientOriginalExtension(),
                        'mime' => $request->file->getMimeType())
                );
            }
        });
    }


    public function update(Request $request, $user_id, $id)
    {
        //
    }

    public function destroy(Request $request, $user_id, $id)
    {
        //
    }
}
