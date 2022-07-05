@php
$districts = \App\District::all();
$workplaces = \App\WorkPlace::all();
$sponsors = \App\Sponsor::all();
$fields = \App\Fieldofficer::all();
$villages = \App\Village::all();
@endphp

<div class="modal fade" id="AddWheelChairModal" tabindex="300" role="dialog"
    aria-labelledby="AddWheelChairModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="wheelchairStore">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddWheelChairModalLabel">Add WheelChair</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mt-3">
                        <label for="name">Name*</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name"
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
                        <label for="latest_repair">Latest Maintenance</label>
                        <input type="date" name="latest_repair" id="latest_repair" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="next_repair">Next Maintenance</label>
                        <input type="date" name="next_repair" id="next_repair" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="wheelchair_field_id">Field Officer*</label>
                        <select class="form-control" name="field_id" id="wheelchair_field_id" required>
                            <option>Select Field Officer</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="wheelchair_sponsor_id">Sponsor*</label>
                        <select class="form-control" name="sponsor_id" id="wheelchair_sponsor_id" required>
                            <option>Select Sponsor</option>
                            @foreach ($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
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
