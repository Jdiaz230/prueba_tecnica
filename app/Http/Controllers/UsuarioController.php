<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;


class UsuarioController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user     = Auth::user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {

        $title              = 'Tipos de Actividad';
        // $create             = route('create.profesional');
        // $sideserver         = route('sideserver.profesional');
        // dd($user->nombre);
        return view('profesional.index', compact('title'));

    }


    public function edit($id)
    {
        $edit           = Profesional::find($id);
        $route          = route('update.profesional', $edit->id);
        $title          = 'Actualizar información';
        return view('profesional.edit', compact('edit', 'route', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\Usuario  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id) {

        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'nombre'                                => 'required|max:20',
            'estado'                                => 'required|numeric',
        ], [
            'required'                              => 'El campo :attribute es requerido.',
            'max'                                   => 'El campo :attribute no puede ser mayor a :max caracteres.',
            'numeric'                               => 'El campo :attribute debe ser un numerico.',
            'email'                                 => 'El campo :attribute debe ser tipo email.',
            'nullable'                              => 'El campo debe ser tipo nulo o vacio.',
        ]);

        if ($validator->fails()) {
            return response()->json(array(  'status'    => 0,
                                            'message'   => 'Los campos con * son obligatorios',
                                            'errors'    => $validat = $validator->errors()->all()
            ));
            exit;
        }

        $actividad                                      = Profesional::find($id);
        if($actividad)
        {
            $actividad->nombre                          = $request->nombre;
            $actividad->estado                          = $request->estado;

            if($actividad->save()){
                return response()->json(['status'       => 1,
                                        'message'       => 'El registro se ha actualizado correctamente.'
                                        ]);
            }else{
                return response()->json(['status'       => 0,
                                        'message'       => 'Ha ocurrido un error al actualizar el registro.'
                                        ]);
            }
        }else{
            return response()->json(['status'           => 0,
                                    'message'           => 'El registro no existe.'
                                    ]);
        }
    }



}
