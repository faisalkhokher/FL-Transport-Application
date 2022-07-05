@php
$villages = \App\Village::all();
$ambulances = \App\Ambulance::all();
@endphp

<div class="modal fade" id="EditAmbulancusageeModal" tabindex="300" role="dialog"
    aria-labelledby="EditAmbulancusageeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="editAmbulanceUsageForm">
                <input type="hidden" name="id" id="editAmbulanceusageId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" >Edit Ambulance Usage</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mt-3">
                        <label for="au_village">Village*</label>
                        <select class="custom-select" name="village_id" id="au_village">
                            <option selected>Select Village</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="au_ambulance">Ambulance*</label>
                        <select class="form-control" name="ambulance_id" id="au_ambulance">
                            <option selected>Select Ambulance</option>
                          </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="au_date">Date*</label>
                        <input type="date" name="date" id="au_date" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="au_name">Name*</label>
                        <input type="text" name="name" id="au_name" class="form-control" placeholder="Enter Name"
                            required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="au_patient">Age*</label>
                        <input type="text" name="age_of_patient" id="au_patient" class="form-control" placeholder="Enter Name"
                            required />
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                          <label>Gender*</label>
                          <div class="mt-3">
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="au_male" value="male"> Male
                              </label>
                              <label class="radio-inline ml-2">
                                <input type="radio" name="gender" id="au_female" value="female"> Female
                              </label>
                          </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label for="au_health">Health facility*</label>
                        <input type="text" name="health_facility" id="au_health" class="form-control"
                            placeholder="Enter Health Facility" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="au_tod">Time of departure*</label>
                        <input type="time" name="time_of_departure" id="au_tod" class="form-control"
                            placeholder="Enter departure time" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="au_toc">Type of case*</label>
                        <input type="text" name="type_of_case" id="au_toc" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Yes" name="deceased" id="au_dea" style="margin-left: 0px;">
                          <label class="form-check-label" for="au_dea">Deceased</label>
                        </div>
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
