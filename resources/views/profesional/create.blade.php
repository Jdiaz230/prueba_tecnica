<!-- create_modal.blade.php -->

<!-- Modal for creating an item -->
<div class="modal fade" id="createItemModal" tabindex="-1" role="dialog" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Crear historia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Your form to create an item goes here -->
                <form action="" method="POST">
                    @csrf
                    <label for="itemName">Item Name:</label>
                    <input type="text" id="itemName" name="name" required>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
