@extends('admin.layouts.app')
@section('content')
    <style type="text/css" rel="stylesheet">
        .upload_image_box{
            width: 70%;
            margin-left: 15%;
            margin-right: 15%;
            height: 146px;
            /*background-color: #16192F;*/
            background-clip: padding-box;
            border: 1px solid #2D3153;
            border-radius: 5px;
            font-size: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .upload_image_box.uploaded img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media only screen and (max-width: 767px){
            .upload_image_box {
                width: 270px;
                height: 270px;
                margin: auto;
            }
        }

        @media only screen and (max-width: 390px){
            .upload_image_box {
                width: 200px;
                height: 200px;
                margin: auto;
            }
        }
    </style>

    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">TRANSPORT4TRANSPORT - <span class="text-primary">EDIT PROFILE</span></h4>
            </div>
        </div>

        <div class="row" id="updateProfilePage">
            <div class="col-12">
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
                            Personal Details
                        </h6>
                        @if($Role == 1)
                        <form action="{{url('admin/update-personal-details')}}" method="post" id="updatePersonalDetailsForm" enctype="multipart/form-data">
                        @elseif($Role == 2)
                        <form action="{{url('reader/update-personal-details')}}" method="post" id="updatePersonalDetailsForm" enctype="multipart/form-data">
                        @endif
                            @csrf
                            <input type="hidden" name="oldProfilePicture" id="oldProfilePicture" value="{{$Profile[0]->profile_picture}}" />
                            <div class="row">
                                {{-- Personal Details Fields --}}
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="firstName">First Name</label>
                                                <input type="text" class="form-control" name="firstName" id="firstName" value="{{$Profile[0]->firstname}}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="middleName">Middle Name</label>
                                                <input type="text" class="form-control" name="middleName" id="middleName" value="{{$Profile[0]->middlename}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lastName">Last Name</label>
                                                <input type="text" class="form-control" name="lastName" id="lastName" value="{{$Profile[0]->lastname}}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dob">DOB</label>
                                                <input type="date" class="form-control" name="dob" id="dob" value="{{$Profile[0]->dob}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="phone">Phone 1</label>
                                                <input type="text" class="form-control" name="phone" id="phone" value="{{$Profile[0]->phone}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="phone">Phone 2</label>
                                                <input type="text" class="form-control" name="phone2" id="phone2" value="{{$Profile[0]->phone2}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Street</label>
                                                <input type="text" class="form-control" name="street" id="street" value="{{$Profile[0]->street}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control" name="city" id="city" value="{{$Profile[0]->city}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">State</label>
                                                <input type="text" class="form-control" name="state" id="state" value="{{$Profile[0]->state}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" name="country" id="country" value="{{$Profile[0]->country}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Zip code/Postal Code</label>
                                                <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{$Profile[0]->zipcode}}"
                                                onkeypress="limitKeypress(event,this.value,5)" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Profile Picture --}}
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-3">
                                            <div class="upload_image_box">
                                                @if($Profile[0]->profile_picture != null)
                                                    <img src="{{asset('public/storage/profile-pics/' . $Profile[0]->profile_picture)}}" alt="Profile Picture" id="userProfileUpdatePreview" style="width: 150px;" />
                                                @else
                                                    <img src="{{asset('public/storage/profile-pics/admin_12345.jpg')}}" alt="Profile Picture" id="userProfileUpdatePreview" style="width: 150px;" />
                                                @endif
                                                <input type="file" style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;' name="userProfileUpdate" id="userProfileUpdate" accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="updatePersonalDetails" id="updatePersonalDetails"><i class="fa fa-check"></i> Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            Account Security <small>(You will be logout)</small>
                        </h6>
                        @if($Role == 1)
                        <form method="post" action="{{url('admin/update-account-security')}}" id="changePasswordForm">
                        @elseif($Role == 2)
                        <form method="post" action="{{url('reader/update-account-security')}}" id="changePasswordForm">
                        @endif
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}" />
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="newPassword">New Password*</label>
                                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New Password" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm Password*</label>
                                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="New Password" required />
                                        <span id="changePasswordError" class="text-small text-danger" style="display: none;">Passwords not matched</span>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="updateSecurityDetails" id="updateSecurityDetails"><i class="fa fa-check"></i> Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
