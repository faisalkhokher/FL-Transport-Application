@php
$districts = \App\District::all();
$workplaces = \App\WorkPlace::all();
$sponsors = \App\Sponsor::all();
$fields = \App\Fieldofficer::all();
$villages = \App\Village::all();
@endphp

<div class="modal fade" id="EditWheelChairModal" tabindex="300" role="dialog"
    aria-labelledby="editTrainingRoomVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="EdidWheelChairForm">

                <input type="hidden" name="id" id="editWheelchairId" value="" />

                <div class="modal-header">
                    <h5 class="modal-title" id="editTrainingRoomVideoModalLabel">Edit WheelChairs</h5>
                </div>
                <div class="modal-body">

                    <div class="col-md-12 mb-12  ">
                        <label for="productname">Name*</label>
                        <input type="text" name="name" id="wheel_name" class="form-control" placeholder="Enter Name"
                            required />
                    </div>


                    <div class="col-md-12 mb-12  mt-3">
                        <label for="productname">Latitude*</label>
                        <input type="text" name="latitude" id="wheel_latitude" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>

                    <div class="col-md-12 mb-12  mt-3">
                        <label for="productname">Longitude*</label>
                        <input type="text" name="longitude" id="wheel_lonfitude" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>

                    <div class="col-md-12 mb-12  mt-3">
                        <label for="productname">Latest Maintenance</label>
                        <input type="date" name="latest_repair" id="wheel_latestrepair" class="form-control" required />
                    </div>

                    <div class="col-md-12 mb-12  mt-3">
                        <label for="productname">Next Maintenance</label>
                        <input type="date" name="next_repair" id="wheel_nextrepair" class="form-control" required />
                    </div>

                    <div class="col-md-12 mb-12  mt-3">
                        <label for="productname">Field Officers*</label>
                        <select class="custom-select" name="field_id" id="edidWheelchair_id" required>
                            <option>Select Field Officer</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-12  mt-3">
                        <label for="productname">Sponsor*</label>
                        <select class="custom-select" name="sponsor_id" id="editSponsor_id" required>
                            <option>Select Sponsor</option>
                            @foreach ($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                            @endforeach
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
