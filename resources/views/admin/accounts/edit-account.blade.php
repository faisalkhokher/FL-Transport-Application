@extends('admin.layouts.app')
@section('content')
    <style type="text/css" rel="stylesheet">
        .upload_image_box {
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

        .upload_image_box.uploaded img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media only screen and (max-width: 767px) {
            .upload_image_box {
                width: 270px;
                height: 270px;
                margin: auto;
            }
        }

        @media only screen and (max-width: 390px) {
            .upload_image_box {
                width: 200px;
                height: 200px;
                margin: auto;
            }
        }
    </style>

    <div class="page-content" id="editAccountPage">
        <div class="flex-wrap d-flex justify-content-between align-items-center grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Transport4Transport - <span class="text-primary">ACCOUNT OVERVIEW</span></h4>
            </div>

            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <?php
                $Url = url('admin/accounts');
                ?>
                <button type="button" class="btn btn-primary btn-icon-text" onclick="window.location.href='{{$Url}}';">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </button>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-12">
                <div class="alert alert-success" id="success-alert" style="display: none;"></div>
                <div class="alert alert-danger" id="error-alert" style="display: none;"></div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            EDIT ACCOUNT
                        </h6>
                        <form action="{{url('admin/accounts/update')}}" id="editAccountForm"
                              enctype="multipart/form-data" method="post">
                            @csrf
                            <input type="hidden" name="id" id="editAccountId" value="{{$User[0]->id}}" />
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="add_email">Email*</label>
                                                <input type="email" class="form-control" name="email" id="add_email"
                                                       placeholder="Enter Email Address" value="{{$User[0]->email}}" onkeypress="ChangeEmailAddress();" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="newPassword">New Password*</label>
                                                <input type="password" class="form-control" name="password"
                                                       id="newPassword" placeholder="New Password"  onkeyup="PasswordConfirmPasswordCheck();" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="confirmPassword">Confirm Password*</label>
                                                <input type="password" class="form-control" name="password_confirmation"
                                                       id="confirmPassword" placeholder="New Password" onkeyup="PasswordConfirmPasswordCheck();" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="role_id">Role*</label>
                                                <select class="custom-select" name="role_id" id="role_id" required>
                                                    @foreach ($roles as $role)
                                                        @if($role->id == $User[0]->role_id)
                                                            <option value="{{ $role->id }}"
                                                                    selected>{{ $role->title }}</option>
                                                        @else
                                                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="inlineRadio2">State*</label>
                                                <div class="mt-2">
                                                    @if($User[0]->status == 1)
                                                        <label class="radio-inline">
                                                            <input type="radio" name="status" id="inlineRadio2" value="1"
                                                                   checked> Active
                                                        </label>
                                                        <label class="radio-inline ml-2">
                                                            <input type="radio" name="status" id="inlineRadio3" value="0">
                                                            Blocked
                                                        </label>
                                                    @else
                                                        <label class="radio-inline">
                                                            <input type="radio" name="status" id="inlineRadio2" value="1"> Active
                                                        </label>
                                                        <label class="radio-inline ml-2">
                                                            <input type="radio" name="status" id="inlineRadio3" value="0" checked>
                                                            Blocked
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="firstName">First Name</label>
                                                <input type="text" class="form-control" name="firstName" id="firstName"
                                                       onkeypress="ChangeFirstName();" value="{{$Profile[0]->firstname}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="middleName">Middle Name</label>
                                                <input type="text" class="form-control" name="middleName" id="middleName" value="{{$Profile[0]->middlename}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="lastName">Last Name</label>
                                                <input type="text" class="form-control" name="lastName" id="lastName"
                                                       onkeypress="ChangeLastName();" value="{{$Profile[0]->lastname}}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="dob">DOB</label>
                                                <input type="date" class="form-control" name="dob" id="dob" value="{{$Profile[0]->dob}}"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="phone">Phone 1</label>
                                                <input type="text" class="form-control" name="phone" id="phone" value="{{$Profile[0]->phone}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="phone2">Phone 2</label>
                                                <input type="text" class="form-control" name="phone2" id="phone2" value="{{$Profile[0]->phone2}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="street">Street</label>
                                                <input type="text" class="form-control" name="street" id="street" value="{{$Profile[0]->street}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control" name="city" id="city" value="{{$Profile[0]->city}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="state">State</label>
                                                <input type="text" class="form-control" name="state" id="state" value="{{$Profile[0]->state}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <input type="text" class="form-control" name="country" id="country" value="{{$Profile[0]->country}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="zipcode">Zip code/Postal Code</label>
                                                <input type="text" class="form-control" name="zipcode" id="zipcode" value="{{$Profile[0]->zipcode}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-3">
                                            <div class="upload_image_box">
                                                <input type="hidden" name="oldProfilePicture" id="oldProfilePicture" value="{{$Profile[0]->profile_picture}}">
                                                <?php
                                                $Url = asset('public/storage/profile-pics/admin_12345.jpg');
                                                if ($Profile[0]->profile_picture != '') {
                                                    $Url = asset('public/storage/profile-pics/') . '/' . $Profile[0]->profile_picture;
                                                }
                                                ?>
                                                <img src="{{$Url}}"
                                                     alt="Profile Picture"
                                                     id="userProfileUpdatePreview"
                                                     style="width: 150px;"/>
                                                <input type="file"
                                                       style='filter: alpha(opacity=0);opacity:0; background-color:transparent; position: absolute; width: 100%; height: 100%; cursor: pointer;'
                                                       name="profile_picture"
                                                       id="userProfileUpdate"
                                                       accept=".jpeg,.png,.jpg,.JPEG,.PNG,.JPG"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="editAccountForm"
                                            id="saveAccountBtn">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection