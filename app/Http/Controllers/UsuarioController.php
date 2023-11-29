<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Historial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;



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

        $title                    = 'Tipos de Actividad';
        $user                     = Auth::user();
        $create                   = route('create.historial');
        $edit                     = route('edit.profesional', $user->id);
        $sideserver               = route('sideserver.profesional');

        if($user->tipo == 'PACIENTE'){
            $historiales              = Historial::where(['id_paciente'=> $user->id])->latest()->paginate(10);
        }else if($user->tipo == 'PROFESIONAL'){
            $historiales              = Historial::where(['id_usuario'=> $user->id])->latest()->paginate(10);
        }


        return view('profesional.index', compact('title','edit','user','create','sideserver','historiales'));

    }


    public function edit($id)
    {
        $edit           = User::find($id);
        $route          = route('update.profesional', $edit->id);
        // $index          = route('profesional');
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
            'nombre'                                => 'required|',
            'apellido'                              => 'required|',
            'numero_identificacion'                 => 'required|numeric',
            'numero_celular'                        => 'required|numeric',
            'ubicacion'                             => 'required|',
            'tipo'                                  => 'required|',
            'email'                                 => 'required|',
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

        $update                                      = User::find($id);
        if($update)
        {
            $update->nombre                          = $request->nombre;
            $update->apellido                        = $request->apellido;
            $update->numero_identificacion           = $request->numero_identificacion;
            $update->numero_celular                  = $request->numero_celular;
            $update->ubicacion                       = $request->ubicacion;
            $update->tipo                            = $request->tipo;
            $update->email                           = $request->email;

            if($update->save()){
                // return response()->json(['status'       => 1,
                //                         'message'       => 'El registro se ha actualizado correctamente.'
                //                         ]);
                return redirect()->route('profesional')->with('success', 'Item successfully created!');
            }else{
                // return response()->json(['status'       => 0,
                //                         'message'       => 'Ha ocurrido un error al actualizar el registro.'
                //                         ]);
                return redirect()->back()->withErrors(['message' => 'Error occurred!']);
            }
        }else{
            // return response()->json(['status'           => 0,
            //                         'message'           => 'El registro no existe.'
            //                         ]);
            return redirect()->route('profesional')->with('success', 'Item successfully created!');
        }
    }
}
