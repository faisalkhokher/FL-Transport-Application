@extends('admin.layouts.app')
@section('content')
    <div class="page-content" id="VillagesPage">
        <div class="flex-wrap d-flex justify-content-between align-items-center grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Transport4Transport - <span class="text-primary">ACCOUNT OVERVIEW</span></h4>
            </div>

            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <?php
                $Url = url('admin/accounts/add');
                ?>
                <button type="button" class="btn btn-primary btn-icon-text" onclick="window.location.href='{{$Url}}';">
                    <i class="fas fa-plus-square mr-1"></i>
                    Add
                </button>
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
                            PERSONAL DETAILS
                        </h6>
                        <div class="table-responsive">
                            <table id="admin_accounts" class="table w-100">
                                <thead>
                                <tr>
                                    <th style="width:5%;">#</th>
                                    <th style="width:20%;">Name</th>
                                    <th style="width:20%;">Email</th>
                                    <th style="width:20%;">Logged In</th>
                                    <th style="width:10%;">Role</th>
                                    <th style="width:10%;">Status</th>
                                    <th style="width:15%;">Action</th>
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
    @include('admin.accounts.add')
    @include('admin.accounts.delete')
    @include('admin.accounts.edit')


    <script type="text/javascript">
        let roles = [];
        roles = JSON.parse('<?= $roles; ?>');
        </script>
@endsection
