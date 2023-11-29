@extends('layouts.app')
@section('content')

<div class="container-fluid" id="edit_modal">
<div class="container" >

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-theme">
                <div class="card-header">
            <div class="modal-header">
                <h5 class="modal-title" >{{$title}}</h5>
            </div>
            <div class="modal-body">

                <form action="{{$route}}" id="form_save" method="POST" >
                    @csrf <!-- Include this line to add the CSRF token field -->
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="id_paciente" class="control-label capit"> Paciente </label>
                                <select name="id_paciente" id="id_paciente" class="form-control select2"
                                aria-describedby="id_pacienteHelp" required>
                                        <option value="">SELECCIONA UN PACIENTE</option>
                                    @if ($pacientes)
                                        @foreach ($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
                                        @endforeach
                                    @else
                                        <option value="">NO EXISTEN REGISTROS</option>
                                    @endif
                                </select>
                                <small id="id_pacienteHelp" class="form-text text-muted"></small>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="fecha" class="control-label capit"> Fecha </label>
                                <input type="date" name="fecha" id="fecha" class="form-control mayus" autocomplete="off"
                                 aria-describedby="fechaHelp" required >
                                <small id="fechaHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="hora" class="control-label capit"> Hora </label>
                                <input type="time" name="hora" id="hora" class="form-control mayus" autocomplete="off"
                                aria-describedby="horaHelp" required >
                                <small id="horaHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="consecutivo" class="control-label capit"> Consecutivo </label>
                                <input type="number" name="consecutivo" id="consecutivo" class="form-control mayus" autocomplete="off"
                                placeholder="consecutivo" aria-describedby="consecutivoHelp" onkeyup="Mayuscula(this);" required  >
                                <small id="consecutivoHelp" class="form-text text-muted"></small>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="estado" class="control-label capit"> Estado </label>
                                <input type="number" name="estado" id="estado" class="form-control mayus" autocomplete="off"
                                placeholder="estado" aria-describedby="estadoHelp" onkeyup="Mayuscula(this);" required  >
                                <small id="estadoHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="informacion_antecedentes" class="control-label capit"> Informacion de antecedentes </label>
                                <input type="text" name="informacion_antecedentes" id="informacion_antecedentes" class="form-control mayus" autocomplete="off"
                                placeholder="informacion_antecedentes" aria-describedby="informacion_antecedentesHelp" onkeyup="Mayuscula(this);" required >
                                <small id="informacion_antecedentesHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="evolucion_final" class="control-label capit"> Evolucion final </label>
                                <input type="textt" name="evolucion_final" id="evolucion_final" class="form-control mayus" autocomplete="off"
                                placeholder="evolucion_final" aria-describedby="evolucion_finalHelp" onkeyup="Mayuscula(this);" required  >
                                <small id="evolucion_finalHelp" class="form-text text-muted"></small>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="concepto_profesional" class="control-label capit"> Concepto profesional </label>
                                <input type="text" name="concepto_profesional" id="concepto_profesional" class="form-control mayus" autocomplete="off"
                                placeholder="Concepto del profesional" aria-describedby="concepto_profesionalHelp" onkeyup="Mayuscula(this);" required  >
                                <small id="concepto_profesionalHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="recomendaciones" class="control-label capit"> Recomendaciones </label>
                                <input type="text" name="recomendaciones" id="recomendaciones" class="form-control mayus" autocomplete="off"
                                placeholder="recomendaciones" aria-describedby="recomendacionesHelp" onkeyup="Mayuscula(this);" required >
                                <small id="recomendacionesHelp" class="form-text text-muted"></small>
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

            </div>
        </div>
    </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error en el registro!</strong> Revisa los errores..<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
</div>
@endsection


