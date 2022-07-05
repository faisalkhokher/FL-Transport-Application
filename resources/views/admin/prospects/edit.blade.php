@php
$districts = \App\District::all();
$workplaces = \App\WorkPlace::all();
$sponsors = \App\Sponsor::all();
$fields = \App\Fieldofficer::all();
$villages = \App\Village::all();
@endphp

<div class="modal fade" id="EditProspectModal" tabindex="300" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editProspectForm">
                <input type="hidden" name="id" id="prospect_id" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="addProspect">Edit Prospect</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mt-3">
                        <label for="productname">Title*</label>
                        <input type="text" name="title" id="prospectEdit_title" class="form-control" placeholder="Enter Name"
                            required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Latitude*</label>
                        <input type="text" name="latitude" id="prospectEdit_lat" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Longitude*</label>
                        <input type="text" name="longitude" id="prospectEdit_long" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Start date*</label>
                        <input type="date" name="start_time" id="prospectEdit_startdate" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Ent date*</label>
                        <input type="date" name="end_time" id="prospectEdit_enddate" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Sponsor*</label>
                        <select class="custom-select" name="sponsor_id" id="prospectEdit_sponsorID">
                            <option selected>Select Sponsor</option>
                            @foreach ($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Field Officer*</label>
                        <select class="custom-select" name="field_id" id="prospectEdit_feildID">
                            <option selected>Select Field Officer</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="my-textarea">Description</label>
                        <textarea  class="form-control" name="description" rows="3" id="prospectEdit_description"></textarea>
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
