<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;
use App\Models\Firmas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class HistoriaController extends Controller
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
    public function index()
    {
        return view('prueba');
    }

    public function create()
    {
        // $edit           = User::find($id);
        $route          = route('store.historial');
        $pacientes      = User::where(['tipo'=> 'PACIENTE'])->get();
        $title          = 'Creacion de historia';
        // dd($paciente);
        return view('historial.create', compact( 'route', 'title','pacientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('entre al store de historial ');
       $request->validate([
            'id_paciente'                           => 'required|numeric',
            'fecha'                                 => 'required|',
            'hora'                                  => 'required|',
            'consecutivo'                           => 'required|numeric',
            'estado'                                => 'required|',
            'informacion_antecedentes'              => 'required|',
            'evolucion_final'                       => 'required|',
            'concepto_profesional'                  => 'required|',
            'recomendaciones'                       => 'required|',

        ]);


        $reg                                      = new Historial;

        $reg->id_usuario                          = Auth::user()->id;
        $reg->id_paciente                         = $request->id_paciente;
        $reg->fecha                               = $request->fecha;
        $reg->hora                                = $request->hora;
        $reg->consecutivo                         = $request->consecutivo;
        $reg->estado                              = $request->estado;
        $reg->informacion_antecedentes            = $request->informacion_antecedentes;
        $reg->evolucion_final                     = $request->evolucion_final;
        $reg->concepto_profesional                = $request->concepto_profesional;
        $reg->recomendaciones                     = $request->recomendaciones;

        if($reg->save()){
            // return response()->json(['status'       => 1,
            //                         'message'       => 'El registro se ha actualizado correctamente.'
            //                         ]);
            return redirect()->route('profesional')->with('success', 'Item successfully created!');

        }else{
            return redirect()->back()->withErrors(['message' => 'Error occurred!']);

        }

    }
    public function upload(Request $request, $id_historial)
    {
        // Get the signed data from the request
        $signedData = $request->input('signed');

        // Process the received data further as needed
        // For example, splitting the base64 string
        $splitData = explode(',', $signedData);
        $base64String = isset($splitData[1]) ? $splitData[1] : null;

        // DB::beginTransaction();
        try {

                $historial                          = Historial::find($id_historial)->id_usuario;
            // dd($base64String);
                $firma                              = new Firmas();
                $firma->id_user                     = $historial;
                $firma->id_historial                = $id_historial;
                $firma->firma                       = $base64String;
                $firma->save();

                $id_firma                           = $firma->id;
                $update                             = Historial::find($id_historial);
                $update->id_firma                   = $id_firma;
                $update->estado_firma               = 1;
                $update->save();

                // Guardado de imagen de la firma
                $folderPath                             = public_path('upload/');
                $image_parts                            = explode(";base64,", $request->signed);
                $image_type_aux                         = explode("image/", $image_parts[0]);
                $image_type                             = $image_type_aux[1];
                $image_base64                           = base64_decode($image_parts[1]);
                $file                                   = $folderPath . uniqid() . '.'.$image_type;
                                                            file_put_contents($file, $image_base64);


         } catch (Exception $e)
         {
            // dd('entre al roll back');
            // DB::rollback();
            return response()->json([
                'status'            => 0,
                'message'           => exceptionMessage($e)
            ]);
         }
            return back()->with('success', 'success Full upload signature');

            // return response()->json([
            //             'status'            => 1,
            //             'message'           => 'El registro se ha guardado correctamente.',
            //         ]);
    }
}
