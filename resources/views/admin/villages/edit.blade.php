<div class="modal fade" id="editVillageModal" tabindex="200" role="dialog" aria-labelledby="editVillageModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/villages/update')}}" id="editFaqForm">
                @csrf
                <input type="hidden" name="id" id="editVillageId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="editVillageModalLabel">Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-12">
                        <label for="editvillagename">Name</label>
                        <input type="text" name="name" id="editvillagename" class="form-control"
                        placeholder="Enter Village Name" required/>
                    </div>
                    <div class="col-md-12 mb-12 mt-3">
                        <label for="village_district_id">Districts</label>
                        <select class="form-control" name="district_id" id="village_district_id">

                        </select>
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
