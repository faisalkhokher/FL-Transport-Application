@php
$districts = \App\District::all();
$workplaces = \App\WorkPlace::all();
$sponsors = \App\Sponsor::all();
$fields = \App\Fieldofficer::all();
$villages = \App\Village::all();
@endphp

<div class="modal fade" id="EditAmbulanceModal" tabindex="300" role="dialog"
    aria-labelledby="EditAmbulanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="edit-Ambulance">
                <input type="hidden" name="id" id="editAmbulanceId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="editTrainingRoomVideoModalLabel">Edit Ambulance</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-12 mt-32 ">
                        <label for="ambulanceName">Name*</label>
                        <input type="text" name="name" id="ambulanceName" class="form-control" placeholder="Enter Name"
                            required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulanceVillage_id">Village*</label>
                        <select class="form-control" name="village_id" id="ambulanceVillage_id">

                        </select>
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulanceLatitude_id">Latitude*</label>
                        <input type="text" name="latitude" id="ambulanceLatitude_id" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulanceLongitutde_id">Longitude*</label>
                        <input type="text" name="longitude" id="ambulanceLongitutde_id" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulanceRepair_id">Latest Maintenance</label>
                        <input type="date" name="lastest_repair" id="ambulanceRepair_id" class="form-control" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulanceNext_id">Next Maintenance</label>
                        <input type="date" name="next_repair" id="ambulanceNext_id" class="form-control" required />
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulanceworkplace_id">WorkPlace*</label>
                        <select class="form-control" name="workplace_id" id="ambulanceworkplace_id">

                        </select>
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulanceSponsor_id">Sponsor*</label>
                        <select class="form-control" name="sponsor_id" id="ambulanceSponsor_id">

                        </select>
                    </div>
                    <div class="col-md-12 mb-12 mt-32 mt-3">
                        <label for="ambulancefeid_ld">Field officer*</label>
                        <select class="form-control" name="field_id" id="ambulancefeid_ld">

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
