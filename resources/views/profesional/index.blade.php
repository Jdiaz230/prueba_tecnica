@extends('layouts.app')
@section('content')

<div class="container-fluid" id="index_modal">
{{-- <div id="response"></div> --}}
    <div class="row">
        <div class="col-12">
            <div class="container">
                <div class="card card-theme">
                    <div class="card-header">
                        @if($user->tipo=='PROFESIONAL')
                        <h3>Historias Realizadas</h3>
                        @else
                        <h3>Historias Medicadas</h3>
                        @endif
                        <div class="modal-footer">
                            @if($user->tipo=='PROFESIONAL')
                            <button onclick="window.location='{{ $create }}'" class="btn btn-primary">Nueva historia</button>
                            @endif
                            <button onclick="window.location='{{ $edit }}'" class="btn btn-secondary">Configuracion</button>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="table-responsive">
                        <div class="card-body">
                            @if($user->tipo=='PACIENTE')
                            <table  class="table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>MEDICO</th>
                                        <th>FECHA</th>
                                        <th>HORA</th>
                                        <th>CONSECUTIVO</th>
                                        <th>ESTADO</th>
                                        <th>INFORMACION DE ANTCE.</th>
                                        <th>EVOLUCION FINAL</th>
                                        <th>CONCEPTO</th>
                                        <th>RECOMENDACIONES</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historiales as $historial)
                                        <tr>
                                            <td>{{ $historial->id }}</td>
                                            <td>{{ $historial->usuario->nombre }}</td>
                                            <td>{{ $historial->fecha }}</td>
                                            <td>{{ $historial->hora }}</td>
                                            <td>{{ $historial->consecutivo }}</td>
                                            <td>{{ $historial->estado }}</td>
                                            <td>{{ $historial->informacion_antecedentes }}</td>
                                            <td>{{ $historial->evolucion_final }}</td>
                                            <td>{{ $historial->concepto_profesional }}</td>
                                            <td>{{ $historial->recomendaciones }}</td>
                                            <td style="text-align: center;">
                                                @if($historial->estado_firma < 1)
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal_{{ $historial->id }}">
                                                    Firma
                                                </button>
                                                @else
                                                <button class="btn btn-success" >ya firmado</button >
                                                @endif
                                            </td>
                                        </tr>
                                        <!--Ventana Modal para Actualizar--->
                                        @include('firma')

                                    @endforeach
                                </tbody>
                            </table>
                            {{ $historiales->links()}}
                            @else
                            <table  class="table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>REALIZADO</th>
                                        <th>INFO</th>
                                        <th>FECHA</th>
                                        <th>HORA</th>
                                        <th>CONSECUTIVO</th>
                                        <th>ESTADO</th>
                                        <th>INFORMACION DE ANTCE.</th>
                                        <th>EVOLUCION FINAL</th>
                                        <th>CONCEPTO</th>
                                        <th>RECOMENDACIONES</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historiales as $historial)
                                        <tr>
                                            <td>{{ $historial->id }}</td>
                                            <td>{{ $historial->usuario->nombre }}</td>
                                            <td>{{ $historial->paciente->nombre }}</td>
                                            <td>{{ $historial->fecha }}</td>
                                            <td>{{ $historial->hora }}</td>
                                            <td>{{ $historial->consecutivo }}</td>
                                            <td>{{ $historial->estado }}</td>
                                            <td>{{ $historial->informacion_antecedentes }}</td>
                                            <td>{{ $historial->evolucion_final }}</td>
                                            <td>{{ $historial->concepto_profesional }}</td>
                                            <td>{{ $historial->recomendaciones }}</td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            {{ $historiales->links()}}
                            @endif
                        </div><!-- /.card-body -->

                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->


</div><!-- /.container -->
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js">

    $(document).ready( function () {
        $('#tabla_historia').DataTable();
        var canvas = document.getElementById('signatureCanvas');
        var signaturePad = new SignaturePad(canvas);

        $('#saveSignatureBtn').click(function() {
            // Get the signature as a data URL
            var signatureData = signaturePad.toDataURL();

            // You can send signatureData to your server for saving or processing
            console.log('Signature Data:', signatureData);

            // Close the modal
            $('#signatureModal').modal('hide');
        });
    });
</script>
{{-- @section('script')
    <script type="text/javascript">

    $("#tabla_historia").attr("data-url");
            datatables('tabla_historia', [
                {data: 'id',orderable: true},
                {data: 'id_usuario',orderable: true},
                {data: 'id_paciente'},
                {data: 'fecha'},
                {data: 'hora'},
                {data: 'consecutivo'},
                {data: 'estado'},
                {data: 'informacion_antecedentes'},
                {data: 'evolucion_final'},
                {data: 'concepto_profesional'},
                {data: 'recomendaciones'}
            ], null);

    </script>
@endsection --}}
