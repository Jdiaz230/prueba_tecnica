
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Actualizar datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form to create an item goes here -->
                <form action="" id="form_save" method="POST" onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="movil" class="control-label capit"> Móvil </label>
                                <input type="number" name="movil" id="movil" class="form-control mayus" autocomplete="off" placeholder="Movil" aria-describedby="movilHelp" onkeyup="Mayuscula(this);" required value="" readonly>
                                <small id="movilHelp" class="form-text text-muted"></small>
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="placa" class="control-label capit"> Placa </label>
                                <input type="text" name="placa" id="placa" class="form-control mayus" autocomplete="off" placeholder="Placa" aria-describedby="placaHelp" onkeyup="Mayuscula(this);" required value="" readonly>
                                <small id="placaHelp" class="form-text text-muted"></small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <div class="form-group">
                                <label for="marca" class="control-label capit"> Marca </label>
                                <input type="text" name="marca" id="marca" class="form-control mayus" autocomplete="off" placeholder="Marca" aria-describedby="marcaHelp" onkeyup="Mayuscula(this);" required value="">
                                <small id="marcaHelp" class="form-text text-muted"></small>
                            </div>
                        </div>

                    </div>
                </form>
                <form action="" method="POST">
                    @csrf
                    <label for="itemName">Item Name:</label>
                    <input type="text" id="itemName" name="name" required>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
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
    </div>
</div>

