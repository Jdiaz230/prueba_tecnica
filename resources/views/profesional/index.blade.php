@extends('layouts.app')
@section('content')
<div class="container-fluid" id="index_modal">

    <div class="row">
        <div class="col-12">
            <div class="container">
                <!-- Buttons to trigger modals -->
                <div class="card card-theme">
                    <div class="card-header">
                        <h3>Bienvenido NOMBRE su rol es : ROL</h3>
                        <div class="row">
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createItemModal">
                                    Crear historia
                                </button>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editItemModal">
                                    Configuracion
                                </button>
                            </div>
                    </div><!-- /.card-header -->
                </div>

                <!-- Include modals -->
                @include('profesional.create') <!-- Include create modal -->
                @include('profesional.edit')   <!-- Include edit modal -->
            </div>


                <div class="card-body">
                    <table id="tabla_sideserver" class="table table-bordered table-striped" style="width: 100%" data-rows="10" data-sort="0" data-type="desc" data-url="">
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
                        <tbody></tbody>
                    </table>
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.col-12 -->
    </div><!-- /.row -->


</div><!-- /.container-fluid -->
@endsection

@section('script')

    <script type="text/javascript">
        // $(function() {
        //     refresh();
        // });

        // function refresh() {
        //     if($("#tabla_sideserver").DataTable()){
        //         $("#tabla_sideserver").DataTable().destroy();
        //     }
        //     datatables('tabla_sideserver', [
        //         { data: 'id' },
        //         { data: 'movil' },
        //         { data: 'placa' },
        //         { data: 'marca' },
        //         { data: 'sede' },
        //         { data: 'responsable' },
        //         { data: 'kilometraje' },
        //         { data: 'estado' },
        //         { data: 'combustible', orderable: false, searchable: false },
        //         { data: 'vervehiculo', orderable: false, searchable: false },
        //         { data: 'datos', orderable: false, searchable: false },
        //     ]);
        //     Load(0);
        // }

    </script>
@endsection
