@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="flex-wrap d-flex justify-content-between align-items-center grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Transport4Transport - <span class="text-primary">Countries</span></h4>
            </div>

            <div class="d-flex align-items-center flex-wrap text-nowrap">
                    
               @if (Session::get('user_role') == 1)
               
               <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0"
               onclick="window.location.href='{{route('add.countries')}}';">
                   <i class="fas fa-plus-square mr-1"></i>
                   Add New Country
               </button>

               @endif


            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-12">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @elseif(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            Details
                        </h6>
                        <div class="table-responsive">
                            <table id="admin_countries_table" class="table w-100">
                                <thead>
                                <tr>
                                    <th style="width:5%;">#</th>
                                    <th style="width:35%;">Name</th>
                                    <th style="width:35%;">Country Code</th>
                                    <th style="width:30%;">Action</th>
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
    </div>
    @include('admin.countries.edit')
    @include('admin.includes.deleteCountriesModal')
@endsection
