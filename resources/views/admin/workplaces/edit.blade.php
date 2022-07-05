<div class="modal fade" id="editWorkplaceModal" tabindex="200" role="dialog" aria-labelledby="editWorkplaceModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/workplaces/update')}}" id="editFaqForm">
                @csrf
                <input type="hidden" name="id" id="editWorkPlaceId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="editWorkplaceModalLabel">Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-12">
                        <label for="editworkplacename">Name</label>
                        <input type="text" name="name" id="editworkplacename" class="form-control"
                        placeholder="Enter Name" required/>
                    </div>
                    <div class="col-md-12 mb-12 mt-3">
                        <label for="village_id">Villages</label>
                        <select class="form-control" name="village_id" id="village_id">

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
