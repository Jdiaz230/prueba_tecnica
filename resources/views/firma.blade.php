
{{-- <div class="modal fade" id="exampleModal_{{ $historial->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <head>
        <title>Laravel Signature Pad Tutorial Example - ItSolutionStuff.com </title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

        <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

        <style>
            .kbw-signature { width: 100%; height: 200;}
            #sig canvas{
                width: 100% !important;
                height: auto;
            }
        </style>

    </head>
    <body >
    <div class="container">
       <div class="row">
           <div class="col-md-6 offset-md-3 mt-5">
               <div class="card">
                   <div class="card-header">
                       <h5>Laravel Signature Pad Tutorial Example - ItSolutionStuff.com </h5>
                   </div>
                   <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success  alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('upload.historial') }}">
                            @csrf
                            <div class="col-md-12">
                                <label class="" for="">Signature:</label>
                                <br/>
                                <div id="sig_{{ $historial->id }}" ></div>
                                <br/>
                                <button id="clear_{{ $historial->id }}" class="btn btn-danger btn-sm">Clear Signature</button>
                                <textarea id="signature64_{{ $historial->id }}" name="signed" style="display: none"></textarea>
                            </div>
                            <br/>
                            <div class="modal-footer">
                                <button class="btn btn-success">Save</button>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                              </div>
                        </form>
                   </div>
               </div>
           </div>
       </div>

    </div>
    <script type="text/javascript">
        var sig = $('#sig_'+ {{$historial->id}}).signature({syncField: '#signature64_'+{{ $historial->id }}, syncFormat: 'PNG'});
        $('#clear_'+{{ $historial->id }}).click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64_"+ {{$historial->id}}).val('');
        });
    </script>

    </body>
</div> --}}

<!-- Main HTML File (Head Section) -->
<head>

    <!-- Include necessary libraries and stylesheets here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="http://keith-wood.name/js/jquery.signature.js"></script>
    <link rel="stylesheet" href="http://keith-wood.name/css/jquery.signature.css">
    <style>
        .kbw-signature { width: auto; height: auto; }
        #sig canvas { width: 100% !important; height: auto; }
    </style>
</head>

<!-- Modal Content -->
<div class="modal fade" id="exampleModal_{{ $historial->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Firmar asistencia historia:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form method="POST" action="{{ route('upload.historial', ['id' => $historial->id]) }}">
                    @csrf
                    <div class="col-md-12">
                        <label class="">Firma:</label>
                        <br/>
                        <div id="sig_{{ $historial->id }}" ></div>
                        <br/>
                        <button id="clear_{{ $historial->id }}" class="btn btn-danger btn-sm">Limpiar Firma</button>
                        <textarea id="signature64_{{ $historial->id }}" name="signed" style="display: none"></textarea>
                    </div>
                    <br/>
                    <div class="modal-footer">
                        <button class="btn btn-success">Realizar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Script Initialization (outside modal) -->
<script>
    $(document).ready(function() {
        var sig = $('#sig_'+{{$historial->id}}).signature({syncField: '#signature64_'+{{$historial->id}}, syncFormat: 'PNG'});
        $('#clear_'+{{$historial->id}}).click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64_"+{{$historial->id}}).val('');
        });
    });
</script>

{{-- <script src="path/to/signature-pad.js"></script>
<script>
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'));

    document.getElementById('save-button').addEventListener('click', function() {
        var signatureData = signaturePad.toDataURL(); // Get signature data
        // Now, send this data to your backend (Laravel) for saving
        // You can use AJAX or form submission to send this data to your Laravel backend
    });
</script> --}}


