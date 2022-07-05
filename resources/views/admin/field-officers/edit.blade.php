<div class="modal fade" id="editFieldOfficersModal" tabindex="200" role="dialog" aria-labelledby="editTrainingRoomVideoModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/field-officer/update')}}" id="editFaqForm">
                @csrf

                <input type="hidden" name="id" id="editFieldId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrainingRoomVideoModalLabel">Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-12">
                        <label for="editfieldofficername">Field Officer Name</label>
                        <input type="text" name="name" id="editfieldofficername" class="form-control"
                        placeholder="Enter Field Officer Name"  required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Update</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
