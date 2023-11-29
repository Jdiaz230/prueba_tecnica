@extends('layouts.app')
@section('content')
<div class="container-fluid" id="edit_modal">

<div class="container" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-theme">
                <div class="card-header">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Actualizar datos</h5>
            </div>
            <div class="modal-body">
                <form action="{{$route}}" id="form_save" method="POST" >
                    @csrf <!-- Include this line to add the CSRF token field -->
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="nombre" class="control-label capit"> Nombre </label>
                                <input type="text" name="nombre" id="nombre" class="form-control mayus" autocomplete="off"
                                placeholder="nombre" aria-describedby="nombreHelp" onkeyup="Mayuscula(this);" required value="{{$edit->nombre}}" >
                                <small id="nombreHelp" class="form-text text-muted"></small>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="apellido" class="control-label capit"> Apellido </label>
                                <input type="text" name="apellido" id="apellido" class="form-control mayus" autocomplete="off"
                                placeholder="apellido" aria-describedby="apellidoHelp" onkeyup="Mayuscula(this);" required value="{{$edit->apellido}}" >
                                <small id="apellidoHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="numero_identificacion" class="control-label capit"> Numero de identificacion </label>
                                <input type="number" name="numero_identificacion" id="numero_identificacion" class="form-control mayus" autocomplete="off"
                                placeholder="numero_identificacion" aria-describedby="numero_identificacionHelp" onkeyup="Mayuscula(this);" required value="{{$edit->numero_identificacion}}">
                                <small id="numero_identificacionHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="numero_celular" class="control-label capit"> Numero de celular </label>
                                <input type="number" name="numero_celular" id="numero_celular" class="form-control mayus" autocomplete="off"
                                placeholder="numero_celular" aria-describedby="numero_celularHelp" onkeyup="Mayuscula(this);" required value="{{$edit->numero_celular}}" >
                                <small id="numero_celularHelp" class="form-text text-muted"></small>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="ubicacion" class="control-label capit"> Ubicacion </label>
                                <input type="text" name="ubicacion" id="ubicacion" class="form-control mayus" autocomplete="off"
                                placeholder="ubicacion" aria-describedby="ubicacionHelp" onkeyup="Mayuscula(this);" required value="{{$edit->ubicacion}}" >
                                <small id="ubicacionHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        @if($edit->tipo == 'PROFESIONAL')
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="tipo" class="control-label capit"> Tipo </label>
                                <select name="tipo" id="tipo" class="form-control select2" required>
                                    <option value="PACIENTE" {{ $edit->tipo === 'PACIENTE' ? 'selected' : '' }}>PACIENTE</option>
                                    <option value="PROFESIONAL" {{ $edit->tipo === 'PROFESIONAL' ? 'selected' : '' }}>PROFESIONAL</option>
                                </select>

                                <small id="tipoHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        @else
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4" hidden>
                            <div class="form-group">
                                <label for="tipo" class="control-label capit"> Tipo </label>
                                <select name="tipo" id="tipo" class="form-control select2" required>
                                    <option value="PACIENTE" {{ $edit->tipo === 'PACIENTE' ? 'selected' : '' }}>PACIENTE</option>
                                    <option value="PROFESIONAL" {{ $edit->tipo === 'PROFESIONAL' ? 'selected' : '' }}>PROFESIONAL</option>
                                </select>

                                <small id="tipoHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        @endif
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="email" class="control-label capit"> Email </label>
                                <input type="email" name="email" id="email" class="form-control mayus" autocomplete="off"
                                placeholder="email" aria-describedby="emailHelp" onkeyup="Mayuscula(this);" required value="{{$edit->email}}">
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Modal footer content -->
                        <!-- Button that navigates back to the index view -->
                        <button onclick="window.location='{{ route('profesional') }}'" class="btn btn-secondary">Volver</button>
                        <button type="submit" class="btn btn-primary pull-right" id="btn_submit">Guardar</button>
                    </div>

                </form>
                {{-- <div class="row">
                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <div class="modal-body">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
</div>
@endsection

