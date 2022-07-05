@php
$districts = \App\District::all();
$workplaces = \App\WorkPlace::all();
$sponsors = \App\Sponsor::all();
$fields = \App\Fieldofficer::all();
$villages = \App\Village::all();
@endphp

<div class="modal fade" id="AddProspectModal" tabindex="300" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="prospectForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProspect">Add Prospect</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mt-3">
                        <label for="title">Title*</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Name"
                            required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="latitude">Latitude*</label>
                        <input type="text" name="latitude" id="latitude" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="longitude">Longitude*</label>
                        <input type="text" name="longitude" id="longitude" class="form-control"
                            placeholder="Enter Longitude" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="start_time">Start date*</label>
                        <input type="date" name="start_time" id="start_time" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="end_time">Ent date*</label>
                        <input type="date" name="end_time" id="end_time" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="prospects_sponsor">Sponsor*</label>
                        <select class="form-control" name="sponsor_id" id="prospects_sponsor">
                            <option selected>Select Sponsor</option>
                            @foreach ($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="prospects_feild">Field Officer*</label>
                        <select class="form-control" name="field_id" id="prospects_feild">
                            <option selected>Select Field Officer</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="description">Description*</label>
                        <textarea id="my-textarea" class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Add</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
