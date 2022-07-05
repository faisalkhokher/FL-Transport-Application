<div class="modal fade" id="deleteWheelchairModal" tabindex="200" role="dialog" aria-labelledby="deleteWheelchairModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form>
                <input type="hidden" name="id" id="deleteWheelchairId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteWheelchairModalLabel">Delete</h5>
                </div>
                <div class="modal-body">
                    <p>Sure you want to delete this wheelchair?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" id="deleteAmbulanceBtn" onclick="confirmDeleteWheelchair();">Delete</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
