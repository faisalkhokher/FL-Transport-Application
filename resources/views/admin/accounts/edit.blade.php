@php
$roles = \App\Roles::all();
@endphp
<div class="modal fade" id="editAccountModal" tabindex="300" role="dialog"
    aria-labelledby="editAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="edit-accounts">
                <input type="hidden" name="id" id="editAccountId" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" >Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="row">
                            {{-- Personal Details Fields --}}
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="account_email">Email*</label>
                                      <input type="email" class="form-control" name="email" id="account_email" placeholder="Email" onkeypress="ChangeEditEmailAddress();" />
                                      <div id="_editMissingEmailError" style="font-size: 11px; color: red; padding-top: 5px;"></div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                   <div class="form-group">
                                      <label for="Password">New Password*</label>
                                      <input type="password" class="form-control" name="password" id="Password" placeholder="New Password" />
                                      <div style="margin-top: 7px;" id="CheckPasswordMatch"></div>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ConfirmPassword">Confirm Password*</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="ConfirmPassword" placeholder="Confirm Password"/>
                                        <div style="margin-top: 7px;" id="CheckPasswordMatch"></div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                         <label for="account_role">Role</label>
                                         <select class="custom-select" name="role_id" id="account_role" >
                                            <option selected>Select Role</option>
                                            @foreach ($roles as $role)
                                              <option value="{{ $role->id }}">{{ $role->title }}</option>
                                            @endforeach
                                          </select>
                                      </div>
                                   </div>
                                   <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="account_sta_true">State</label>
                                        <div class="mt-2">
                                          <label class="radio-inline">
                                            <input type="radio" name="status" id="account_sta_true" value="1"> Active
                                          </label>
                                          <label class="radio-inline ml-2">
                                             <input type="radio" name="status" id="account_sta_false" value="0"> Blocked
                                          </label>
                                         </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_firstname">First Name</label>
                                            <input type="text" class="form-control" onkeypress="ChangeEditFirstName();" name="firstName" id="account_firstname" />
                                            <div id="_editMissingFirstNameError" style="font-size: 11px; color: red; padding-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_middlename">Middle Name</label>
                                            <input type="text" class="form-control" name="middleName" id="account_middlename" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_lastName">Last Name</label>
                                            <input type="text" class="form-control" onkeypress="ChangeEditLastName();" name="lastName" id="account_lastName" />
                                            <div id="_editMissingLastNameError" style="font-size: 11px; color: red; padding-top: 5px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_dob">DOB</label>
                                            <input type="date" class="form-control" name="dob" id="account_dob" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_phone">Phone 1</label>
                                            <input type="text" class="form-control" name="phone" id="account_phone" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_phone2">Phone 2</label>
                                            <input type="text" class="form-control" name="phone2" id="account_phone2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_street">Street</label>
                                            <input type="text" class="form-control" name="street" id="account_street" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_city">City</label>
                                            <input type="text" class="form-control" name="city" id="account_city" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_state">State</label>
                                            <input type="text" class="form-control" name="state" id="account_state" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="accounts_country">Country</label>
                                            <input type="text" class="form-control" name="country" id="accounts_country" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_zipcode">Zip code/Postal Code</label>
                                            <input type="text" class="form-control" name="zipcode" id="account_zipcode" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="account_profile_picture">Profile Image</label>
                                            <input type="file" class="form-control" name="profile_picture" id="account_profile_picture"   />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="accountEdit_btn">Update</button>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
@endsection
