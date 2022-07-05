@php
$villages = \App\Village::all();
$ambulances = \App\Ambulance::all();
@endphp

<div class="modal fade" id="AddAmbulancusageeModal" tabindex="300" role="dialog"
    aria-labelledby="AddAmbulancusageeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="addAmbulanceUsage">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddAmbulancusageeModalLabel">Add Ambulance Usage</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mt-3">
                        <label for="village_id">Village*</label>
                        <select class="form-control" name="village_id" id="village_id">
                            <option selected>Select Village</option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="ambulance_id">Ambulance*</label>
                        <select class="form-control" name="ambulance_id" id="ambulance_id">
                            <option selected>Select Ambulance</option>
                            @foreach ($ambulances as $ambulance)
                            <option value="{{$ambulance->id}}">{{$ambulance->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="date">Date*</label>
                        <input type="date" name="date" id="date" class="form-control" placeholder="Enter date"
                            required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="name">Patient name*</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name"
                            required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="age_of_patient">Age*</label>
                        <input type="text" name="age_of_patient" id="age_of_patient" class="form-control" placeholder="Enter age"
                            required />
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label>Gender*</label>
                          <div class="mt-1">
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="male" checked> Male
                              </label>
                              <label class="radio-inline ml-2">
                                <input type="radio" name="gender" value="female"> Female
                              </label>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="health_facility">Health facility*</label>
                        <input type="text" name="health_facility" id="health_facility" class="form-control"
                            placeholder="Enter health facility" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="time_of_departure">Time of departure*</label>
                        <input type="time" name="time_of_departure" id="time_of_departure" class="form-control"
                            placeholder="Enter time of departure" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="type_of_case">Type of case*</label>
                        <input type="text" name="type_of_case" id="type_of_case" placeholder="Enter type of case" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="Yes" name="deceased" id="deceased" style="margin-left: 0px;">
                          <label class="form-check-label" for="deceased">Deceased</label>
                        </div>
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
