<div class="modal fade" id="editDistrictModal" tabindex="200" role="dialog" aria-labelledby="editDistrictModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/districts/update')}}" id="editDistrictForm">
                @csrf
                <input type="hidden" name="id" id="editDistrictId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="editDistrictModalLabel">Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-12">
                        <label for="editdistrictname">Name</label>
                        <input type="text" name="name" id="editdistrictname" class="form-control"
                        placeholder="Enter District Name" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-3">
                        <label for="country_id">Country</label>
                        <select class="form-control" name="country_id" id="country_id" required>

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
