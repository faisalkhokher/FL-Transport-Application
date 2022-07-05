@extends('admin.layouts.app')
@section('content')
    <style media="screen">
        .IconSetting {
            margin-top: -22px;
            color: green;
        }
    </style>
 
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h4 class="mb-3 mb-md-0">TRANSPORT4TRANSPORT</h4>
                </div>
            </div>


            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ambulance-tab" data-toggle="tab" href="#ambulance" role="tab" aria-controls="ambulance" aria-selected="true">AMBULANCE</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ambulanceusage-tab" data-toggle="tab" href="#ambulanceusage" role="tab" aria-controls="ambulanceusage" aria-selected="false">AMBULANCE USAGE</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="wheelchair-tab" data-toggle="tab" href="#wheelchair" role="tab" aria-controls="wheelchair" aria-selected="false">WHEELCHAIR</a>
                </li>
              

                 <li class="nav-item" role="presentation">
                    <a class="nav-link" id="project-tab" data-toggle="tab" href="#projects" role="tab" aria-controls="projects" aria-selected="false">PROJECTS</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="prospect-tab" data-toggle="tab" href="#prospects" role="tab" aria-controls="prospects" aria-selected="false">PROSPECTS</a>
                </li>

                </ul>

                {{-- Content --}}

                <div class="tab-content" id="myTabContent">

                {{-- Ambulance --}}
                <div class="tab-pane fade show active" id="ambulance" role="tabpanel" aria-labelledby="ambulance-tab">
                
                 <div class="row">
                <div class="col-lg-8 col-xl-8 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                              <h6 class="card-title mb-0"></h6>
                              <div class="table-responsive">
                                <button type="button" class="btn btn-primary btn-icon-text"
                                data-toggle="modal" data-target="#AddAmbulanceModal">
                                    <i class="fas fa-plus-square mr-1"></i>
                                    Add 
                                </button>   
                                <br/>
                                <br/>
                                <table id="admin_ambulance" class="table w-100x">
                                    <thead>
                                    <tr>
                                        <th style="width:12.5%;">name</th>
                                        <th style="width:12.5%;">NameVillage</th>
                                        <th style="width:12.5%;">Latestrepair</th>
                                        <th style="width:12.5%;">Nextrepair</th>
                                        <th style="width:12.5%;">Latitude</th>
                                        <th style="width:12.5%;">Longitude  </th>
                                        <th style="width:12.5%;"> Sponsor</th>
                                        <th style="width:12.5%;">FieldOfficer</th>
                                        <th style="width:12.5%;">action</th>
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
                </div> <!-- row -->
                </div> 

            
                {{-- Ambulance Usage --}}
                <div class="tab-pane fade" id="ambulanceusage" role="tabpanel" aria-labelledby="profile-tab">
                 <div class="row">
                  <div class="col-lg-6 col-xl-6 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                              <h6 class="card-title mb-0"></h6>

                              
                              <div class="table-responsive">
                                <table id="admin_ambulance" class="table w-100">
                                    <thead>
                                    <tr>
                                        <th style="width:12.5%;">No</th>
                                        <th style="width:12.5%;">Date</th>
                                        <th style="width:12.5%;">Patient's Name</th>
                                        <th style="width:12.5%;">Age of Patient</th>
                                        <th style="width:12.5%;">Gender</th>
                                        <th style="width:12.5%;">Village  </th>
                                        <th style="width:12.5%;"> Health Facility</th>
                                        <th style="width:12.5%;">Time of Departur</th>
                                        <th style="width:12.5%;">Types of case</th>
                                        <th style="width:12.5%;">Deceased
                                        </th>
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
                 </div> <!-- row -->
                </div>
                
                {{-- Wheelchair --}}
                <div class="tab-pane fade" id="wheelchair" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                     <div class="col-lg-8 col-xl-8 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                              <h6 class="card-title mb-0"></h6>

                              
                              <div class="table-responsive">


                                <button type="button" class="btn btn-primary btn-icon-text"
                                data-toggle="modal" data-target="#AddWheelChairModal">
                                    <i class="fas fa-plus-square mr-1"></i>
                                    Add 
                                </button>   
                                
                                <br/>
                                   <br/>


                                <table id="admin_wheelchair" class="table w-100">
                                    <thead>
                                    <tr>
                                      
                                        <th style="width:12.5%;">Name</th>
                                        <th style="width:12.5%;">Latitude</th>
                                        <th style="width:12.5%;">Longitude</th>
                                        <th style="width:12.5%;">Latest repair</th>
                                        <th style="width:12.5%;">Next repair</th>
                                        <th style="width:12.5%;">Sponsor</th>
                                        <th style="width:12.5%;">FieldOfficer</th>
                                        <th style="width:12.5%;">action</th>
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
                 </div> <!-- row -->
                </div>

               {{-- Projects --}}
                <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="contact-tab">
                   <div class="row">
                    <div class="col-lg-8 col-xl-8 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                <h6 class="card-title mb-0"></h6>
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-primary btn-icon-text"
                                    data-toggle="modal" data-target="#AddProjectModal">
                                        <i class="fas fa-plus-square mr-1"></i>
                                        Add 
                                    </button>   
                                    <br/>
                                    <br/>
                                    <table id="admin_projects" class="table w-100">
                                        <thead>
                                        <tr>
                                            <th style="width:12.5%;">Title</th>
                                            <th style="width:12.5%;">Start date</th>
                                            <th style="width:12.5%;">End date</th>
                                            <th style="width:12.5%;">Latitude</th>
                                            <th style="width:12.5%;">Longitude  </th>
                                            <th style="width:12.5%;"> Sponsor</th>
                                            <th style="width:12.5%;">Description</th>
                                            <th style="width:12.5%;">action</th>
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
                </div> <!-- row -->
                </div>

                {{-- Projects --}}
                <div class="tab-pane fade" id="prospects" role="tabpanel" aria-labelledby="contact-tab">
                   <div class="row">
                   <div class="col-lg-6 col-xl-6 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline mb-2">
                              <h6 class="card-title mb-0"></h6>

                              
                              <div class="table-responsive">
                                <table id="admin_ambulance" class="table w-100">
                                    <thead>
                                    <tr>
                                        <th style="width:12.5%;">Title</th>
                                        <th style="width:12.5%;">Description</th>
                                        <th style="width:12.5%;">Start date</th>
                                        <th style="width:12.5%;">End date</th>
                                        <th style="width:12.5%;">Latitude</th>                  
                                        <th style="width:12.5%;">Longitude  </th>
                                        <th style="width:12.5%;"> Sponsor</th>
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
                   </div> <!-- row -->
                </div>
            </div>
           


        




          
        </div>

      @include('admin.projects.add');
      @include('admin.projects.delete');

      @include('admin.ambulance.add');
      @include('admin.ambulance.delete');

      @include('admin.wheeelchairs.add');
      @include('admin.wheeelchairs.delete');
@endsection
