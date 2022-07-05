<div class="modal fade" id="editCountryModal" tabindex="200" role="dialog" aria-labelledby="editCountryModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{url('admin/countries/update')}}" id="editCountryForm">
                @csrf
                <input type="hidden" name="id" id="editCountryId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="editCountryModalLabel">Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-12">
                        <label for="editcountryname">Name</label>
                        <input type="text" name="name" id="editcountryname" class="form-control"
                        placeholder="Enter Country Name" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-12 mt-3">
                        <label for="editcountrycode">Country Code</label>
                        <input type="text" name="country_code" id="editcountrycode" class="form-control"
                        placeholder="Enter Country Code" required />
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
