@extends('layouts.app')

@section('content')
<div id="myModalContainer"></div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">

                        <button type="button" class="btn btn-primary" id="showModalBtn">
                            Show Modal
                        </button>
                      <!-- Modal Container -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Modal content here -->
                                    <div class="modal-body" id="modalContent">
                                        <!-- Content from sideserver route will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Include the modal -->
                        {{-- @include('profesional.index') --}}

                    </div>
                    </body>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Add Bootstrap JavaScript and jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- JavaScript to handle modal triggering -->
<script>
 $(document).ready(function(){
        $('#showModalBtn').click(function(){
            // Fetch content from sideserver route
            $.ajax({
                url: '{{ $sideserver }}',
                type: 'GET',
                success: function(data) {
                    // Load the fetched content into the modal
                    $('#modalContent').html(data);
                    // Show the modal
                    $('#myModal').modal('show');
                }
            });
        });
    });
</script>



