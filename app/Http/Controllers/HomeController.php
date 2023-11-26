<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sideserver         = route('profesional');
        return view('home', compact('sideserver'));
    }
    // public function index(Request $request)
    // {

    //     $title              = 'Tipos de Actividad';
    //     // $create             = route('create.profesional');
    //     $sideserver         = route('sideserver.profesional');
    //     // dd($user->nombre);
    //     return view('profesional.index', compact('title'));

    // }
}
