@extends('admin.layouts.app')
@section('content')
    <style media="screen">
        .IconSetting {
            margin-top: -22px;
            color: green;
        }

        table.table {
            width: auto;
            margin:0 auto;
        }

        /** only for the head of the table. */
        table.table thead th {
            padding: 5px 0px 5px 0px;
        }

        /** only for the body of the table. */
        table.table tbody td {
            padding: 5px 0px 5px 0px;
        }

        .table-responsive {
          display: block;
          width: 100%;
          overflow-x: hidden !important;
          -webkit-overflow-scrolling: touch;
        }

        #prospect_title{
          width: 10% !important;
        }
    </style>
    <div class="page-content" id="DashboardPage">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">TRANSPORT4TRANSPORT</h4>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="ambulance-tab" data-toggle="tab" href="#ambulance" role="tab"
                    aria-controls="ambulance" aria-selected="true">AMBULANCE</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="ambulanceusage-tab" data-toggle="tab" href="#ambulanceusage" role="tab"
                    aria-controls="ambulanceusage" aria-selected="false">AMBULANCE USAGE</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="wheelchair-tab" data-toggle="tab" href="#wheelchair" role="tab"
                    aria-controls="wheelchair" aria-selected="false">WHEELCHAIR</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="project-tab" data-toggle="tab" href="#projects" role="tab" aria-controls="projects"
                    aria-selected="false">PROJECTS</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="prospect-tab" data-toggle="tab" href="#prospects" role="tab"
                    aria-controls="prospects" aria-selected="false">PROSPECTS</a>
            </li>
        </ul>
        {{-- Content --}}

        <div class="tab-content" id="myTabContent">
            {{-- Ambulance --}}
            <div class="tab-pane fade show active" id="ambulance" role="tabpanel" aria-labelledby="ambulance-tab">
                <div class="row">
                    <div class="col-lg-9 col-xl-9 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                  <h6 class="card-title mb-0"></h6>
                                  <div class="table-responsive">
                                    @if (Session::get('user_role') == 1)
                                    <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal"
                                        data-target="#AddAmbulanceModal">
                                        <i class="fas fa-plus-square mr-1"></i>
                                        Add
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-icon-text mb-2 mb-md-0 ml-2"
                                    onclick="window.location.href='{{route('ambulance_export')}}';">
                                    <i class="fas fa-file mr-1"></i>
                                    Export
                                    </button>
                                    <br />
                                    <br />
                                    @endif
                                    <table id="admin_ambulance" class="table w-100">
                                        <thead>
                                          <tr>
                                              <th style="width: 10%;">Name</th>
                                              <th style="width: 10%;">Village</th>
                                              <th style="width: 10%;"><?php echo wordwrap("Latest Maintenance", 10, '<br>'); ?></th>
                                              <th style="width: 10%;"><?php echo wordwrap("Next Maintenance", 10, '<br>'); ?></th>
                                              <th style="width: 10%;">Latitude</th>
                                              <th style="width: 10%;">Longitude </th>
                                              <th style="width: 10%;">WorkPlace</th>
                                              <th style="width: 10%;">Sponsor</th>
                                              <th style="width: 10%;"><?php echo wordwrap("Field Officer", 10, '<br>'); ?></th>
                                              <th style="width: 10%;">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-3 stretch-card">
                        <div id="mymap"></div>
                    </div>
                </div> <!-- row -->
            </div>

            {{-- Ambulance Usage --}}
            <div class="tab-pane fade" id="ambulanceusage" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-lg-12 col-xl-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <h6 class="card-title mb-0"></h6>
                                    <div class="table-responsive">
                                    @if (Session::get('user_role') == 1)
                                    <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal"
                                      data-target="#AddAmbulancusageeModal">
                                      <i class="fas fa-plus-square mr-1"></i>
                                      Add
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-icon-text mb-2 mb-md-0 ml-2"
                                    onclick="window.location.href='{{route('ambulanceusage_export')}}';">
                                    <i class="fas fa-file mr-1"></i>
                                    Export
                                    </button>
                                    <br />
                                    <br />
                                    @endif
                                    <table id="admin_ambulance_usage" class="table w-100">
                                        <thead>
                                            <tr class="no-gutters">
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 5%;">Date</th>
                                                <th style="width: 10%;"><?php echo wordwrap("Patient's name", 10, '<br>'); ?></th>
                                                <th style="width: 10%;"><?php echo wordwrap("Age of Patient", 10, '<br>'); ?></th>
                                                <th style="width: 5%;">Gender</th>
                                                <th style="width: 10%;">Village </th>
                                                <th style="width: 10%;"><?php echo wordwrap("Health Facility", 10, '<br>'); ?></th>
                                                <th style="width: 10%;"><?php echo wordwrap("Time of Departure", 10, '<br>'); ?></th>
                                                <th style="width: 10%;"><?php echo wordwrap("Type of case", 10, '<br>'); ?></th>
                                                <th style="width: 5%;">Deceased</th>
                                                <th style="width: 10%;">Ambulance</th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-4 stretch-card">
                        <div id="AmbulanceUsageMap"></div>
                    </div>
                </div> <!-- row -->
            </div>

            {{-- Wheelchair --}}
            <div class="tab-pane fade" id="wheelchair" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-lg-9 col-xl-9 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <h6 class="card-title mb-0"></h6>
                                    <div class="table-responsive">
                                        @if (Session::get('user_role') == 1)
                                        <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal"
                                            data-target="#AddWheelChairModal">
                                            <i class="fas fa-plus-square mr-1"></i>
                                            Add
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-icon-text mb-2 mb-md-0 ml-2"
                                        onclick="window.location.href='{{route('wheelchair_export')}}';">
                                        <i class="fas fa-file mr-1"></i>
                                        Export
                                        </button>
                                        <br />
                                        <br />
                                        @endif
                                        <table id="admin_wheelchair" class="table w-100">
                                            <thead>
                                                <tr class="no-gutters">
                                                    <th style="width:12.5%;">Name</th>
                                                    <th style="width:12.5%;">Latitude</th>
                                                    <th style="width:12.5%;">Longitude</th>
                                                    <th style="width:12.5%;"><?php echo wordwrap("Latest Maintenance", 10, '<br>'); ?></th>
                                                    <th style="width:12.5%;"><?php echo wordwrap("Next Maintenance", 10, '<br>'); ?></th>
                                                    <th style="width:12.5%;">Sponsor</th>
                                                    <th style="width:12.5%;"><?php echo wordwrap("Field Officer", 10, '<br>'); ?></th>
                                                    <th style="width:12.5%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-3 stretch-card">
                        <div id="wheechairmap"></div>
                    </div>
                </div> <!-- row -->
            </div>

            {{-- Projects --}}
            <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-lg-9 col-xl-9 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <h6 class="card-title mb-0"></h6>
                                    <div class="table-responsive">
                                        @if (Session::get('user_role') == 1)
                                        <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal"
                                          data-target="#AddProjectModal">
                                          <i class="fas fa-plus-square mr-1"></i>
                                          Add
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-icon-text mb-2 mb-md-0 ml-2"
                                        onclick="window.location.href='{{route('project_export')}}';">
                                        <i class="fas fa-file mr-1"></i>
                                        Export
                                        </button>
                                        <br /><br />
                                        @endif
                                        <table id="admin_projects" class="table w-100">
                                            <thead>
                                              <tr class="no-gutters">
                                                  <th style="width: 16.5%;">Title</th>
                                                  <th style="width: 10.5%;">Start date</th>
                                                  <th style="width: 10.5%;">End date</th>
                                                  <th style="width: 12.5%;">Latitude</th>
                                                  <th style="width: 12.5%;">Longitude </th>
                                                  <th style="width: 12.5%;">Sponsor</th>
                                                  <th style="width: 12.5%;"><?php echo wordwrap("Field Officer", 10, '<br>'); ?></th>
                                                  <th style="width: 12.5%;">Description</th>
                                                  <th style="width: 12.5%;">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-3 stretch-card">
                        <div id="projecttMap"></div>
                    </div>
                </div> <!-- row -->
            </div>

            {{-- Projects --}}
            <div class="tab-pane fade" id="prospects" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                    <div class="col-lg-9 col-xl-9 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <h6 class="card-title mb-0"></h6>
                                    <div class="table-responsive">
                                        @if (Session::get('user_role') == 1)
                                        <button type="button" class="btn btn-primary btn-icon-text" data-toggle="modal"
                                          data-target="#AddProspectModal">
                                          <i class="fas fa-plus-square mr-1"></i>
                                          Add
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-icon-text mb-2 mb-md-0 ml-2"
                                          onclick="window.location.href='{{route('prospects_export')}}';">
                                          <i class="fas fa-file mr-1"></i>
                                          Export
                                        </button>
                                        <br>
                                        <br>
                                        @endif
                                        <table id="admin_prospect" class="table w-100">
                                            <thead>
                                                <tr>
                                                    <th id="prospect_title">Title</th>
                                                    <th style="width: 15%;">Description</th>
                                                    <th style="width: 8%;">Start date</th>
                                                    <th style="width: 8%;">End date</th>
                                                    <th style="width: 12%;">Latitude</th>
                                                    <th style="width: 12%;">Longitude </th>
                                                    <th style="width: 12%;">Sponsor</th>
                                                    <th style="width: 12%;"><?php echo wordwrap("Field Officer", 10, '<br>'); ?></th>
                                                    <th style="width: 6%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-3 stretch-card">
                        <div id="prospecttMap"></div>
                    </div>
                </div> <!-- row -->
            </div>
        </div>
    </div>

    @include('admin.projects.add')
    @include('admin.projects.delete')
    @include('admin.projects.edit')
    @include('admin.ambulance.add')
    @include('admin.ambulance.delete')
    @include('admin.ambulance.edit');
    @include('admin.ambulance_usage.add')
    @include('admin.ambulance_usage.delete')
    @include('admin.ambulance_usage.edit')
    @include('admin.wheeelchairs.add')
    @include('admin.wheeelchairs.delete')
    @include('admin.wheeelchairs.edit')
    @include('admin.wheeelchairs.wheelchair')
    @include('admin.prospects.delete')
    @include('admin.prospects.add')
    @include('admin.prospects.edit')

    <script type="text/javascript">
    let villages = [];
    villages = JSON.parse('<?= $villages; ?>');
    </script>

    <script type="text/javascript">
    let sponsors = [];
    sponsors = JSON.parse('<?= $sponsors; ?>');
    </script>

    <script type="text/javascript">
    let feildOfficers = [];
    feildOfficers = JSON.parse('<?= $feildoffers; ?>');
    </script>

    <script type="text/javascript">
    let workplaces = [];
    workplaces = JSON.parse('<?= $workplaces; ?>');
    </script>

    <script type="text/javascript">
    let ambulance_markers = [];
    ambulance_markers = JSON.parse('<?= $workplaces; ?>');
    </script>

    <script type="text/javascript">
    let ambulances = [];
    ambulances = JSON.parse('<?= $ambulances; ?>');
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpJEKWaKwzVezm1lNCjJ6u-Psd5CKT7Tk&libraries=places">
    </script>
    
@endsection
