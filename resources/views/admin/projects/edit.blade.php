@php
$districts = \App\District::all();
$workplaces = \App\WorkPlace::all();
$sponsors = \App\Sponsor::all();
$fields = \App\Fieldofficer::all();
$villages = \App\Village::all();
@endphp

<div class="modal fade" id="EditProjectModal" tabindex="300" role="dialog"
    aria-labelledby="EditProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="projectEditForm">
                <input type="hidden" name="id" id="project_id" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="EditProjectModalLabel">Edit Projects</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mt-3">
                        <label for="productname">Title*</label>
                        <input type="text" name="title" id="project_title" class="form-control" placeholder="Enter Name"
                            required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Latitude*</label>
                        <input type="text" name="latitude" id="project_latitude" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Longitude*</label>
                        <input type="text" name="longitude" id="project_longitude" class="form-control"
                            placeholder="Enter Latitude" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Start time*</label>
                        <input type="date" name="start_time" id="project_startdate" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">End time*</label>
                        <input type="date" name="end_time" id="project_enddate" class="form-control" required />
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="my-textarea">Description</label>
                        <textarea id="project_des" class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Field officer*</label>
                        <select class="custom-select" name="field_id" id="editProjectsFeild_id">
                            <option selected>Select Field Officer</option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}">{{ $field->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Sponsor*</label>
                        <select class="custom-select" name="sponsor_id" id="editProjectSponsor_id">
                            <option selected>Select Sponsor</option>
                            @foreach ($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="productname">Village*</label>
                        <select class="custom-select" name="village_id" id="projects_village">
                            <option selected>Select Village</option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}">{{ $village->name }}</option>
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
