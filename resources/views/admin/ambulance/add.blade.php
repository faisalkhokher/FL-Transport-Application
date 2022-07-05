@php
$districts = \App\District::all();
$workplaces = \App\WorkPlace::all();
$sponsors = \App\Sponsor::all();
$fields = \App\Fieldofficer::all();
$villages = \App\Village::all();
@endphp

<div class="modal fade" id="AddAmbulanceModal" tabindex="300" role="dialog"
    aria-labelledby="AddAmbulanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="add-Ambulance">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddAmbulanceModalLabel">Add</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-32 ">
                        <label for="productname">Name*</label>
                        <input type="text" name="name" id="productname" class="form-control" placeholder="Enter Name"
                            required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulance_village">Village*</label>
                        <select class="form-control" name="village_id" id="ambulance_village">
                            <option selected>Select Village</option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="latitude">Latitude*</label>
                        <input type="text" name="latitude" id="latitude" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="longitude">Longitude*</label>
                        <input type="text" name="longitude" id="longitude" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="lastest_repair">Latest Maintenance</label>
                        <input type="date" name="lastest_repair" id="lastest_repair" class="form-control" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="next_repair">Next Maintenance</label>
                        <input type="date" name="next_repair" id="next_repair" class="form-control" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulance_workplace">WorkPlace*</label>
                        <select class="form-control" name="workplace_id" id="ambulance_workplace">
                            <option value="" selected>Select Workplace</option>
                            @foreach ($workplaces as $workplace)
                                <option value="{{ $workplace->id }}">{{ $workplace->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulance_sponsor">Sponsor*</label>
                        <select class="form-control" name="sponsor_id" id="ambulance_sponsor">
                            <option value="" selected>Select Sponsor</option>
                            @foreach ($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulance_feild">Field Officer*</label>
                        <select class="form-control" name="field_id" id="ambulance_feild">
                            <option value="" selected>Select Field Officer</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
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
