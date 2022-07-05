@php
$roles = \App\Roles::all();

@endphp

<div class="modal fade" id="AddAccountModal" tabindex="300" role="dialog"
    aria-labelledby="AddAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="add-accounts">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddAccountModalLabel">Add</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="row">
                            {{-- Personal Details Fields --}}
                            <div class="col-md-12">
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-fill-danger" role="alert">
                                    {{ $error }}
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="add_email">Email*</label>
                                            <input type="email" class="form-control" name="email" id="add_email" placeholder="Enter Email Address" onkeypress="ChangeEmailAddress();" required/>
                                            <div id="_missingEmailError" style="font-size: 11px; color: red; padding-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="newPassword">New Password*</label>
                                            <input type="password" class="form-control" name="password" id="newPassword" placeholder="New Password" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="confirmPassword">Confirm Password*</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="confirmPassword" placeholder="New Password" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="role_id">Role*</label>
                                            <select class="custom-select" name="role_id" id="role_id" required>
                                                @foreach ($roles as $role)
                                                    @if($role->id == 2)
                                                      <option value="{{ $role->id }}" selected>{{ $role->title }}</option>
                                                    @else
                                                      <option value="{{ $role->id }}">{{ $role->title }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="inlineRadio2">State*</label>
                                          <div class="mt-2">
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="inlineRadio2" value="1" checked> Active
                                              </label>
                                              <label class="radio-inline ml-2">
                                                <input type="radio" name="status" id="inlineRadio3" value="0"> Blocked
                                              </label>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" name="firstName" id="firstName" onkeypress="ChangeFirstName();" required />
                                            <div id="_missingFirstNameError" style="font-size: 11px; color: red; padding-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="middleName">Middle Name</label>
                                            <input type="text" class="form-control" name="middleName" id="middleName" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" name="lastName" id="lastName" onkeypress="ChangeLastName();" required />
                                            <div id="_missingLastNameError" style="font-size: 11px; color: red; padding-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dob">DOB</label>
                                            <input type="date" class="form-control" name="dob" id="dob" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone">Phone 1</label>
                                            <input type="text" class="form-control" name="phone" id="phone" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone2">Phone 2</label>
                                            <input type="text" class="form-control" name="phone2" id="phone2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="street">Street</label>
                                            <input type="text" class="form-control" name="street" id="street"  />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" id="city" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state" id="state" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" id="country" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="zipcode">Zip code/Postal Code</label>
                                            <input type="text" class="form-control" name="zipcode" id="zipcode" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="profile_picture">Profile Image</label>
                                            <input type="file" class="form-control" name="profile_picture" id="profile_picture" />
                                        </div>
                                    </div>
                                </div>
                            </div>
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
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ProfileRequest', '#add-accounts'); !!}
@endsection
