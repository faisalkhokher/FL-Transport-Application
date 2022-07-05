<div class="modal fade" id="editSponsorsModal" tabindex="200" role="dialog" aria-labelledby="editLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/sponsors/update')}}" >
                @csrf

                <input type="hidden" name="id" id="editSponsorsId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" >Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-12">
                        <label for="editsponsername">Name</label>
                        <input type="text" name="name" id="editsponsername" class="form-control"
                        placeholder="Enter Sponser Name"  required/>
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
