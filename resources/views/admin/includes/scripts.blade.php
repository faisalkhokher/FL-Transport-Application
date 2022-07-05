<script type="text/javascript">
    $(document).ready(function () {
        $("#toggleSidebar")[0].click();
        $.mask.definitions['~'] = '[+-]';

        MakeFieldOfficersTable();
        MakeSponsorsTable();
        MakeCountriesTable();
        MakeDistrictsTable();
        MakevillagesTable();
        MakeWorkPlacesTable();
        MakeAmbulanceTable();
        MakeAddProspectsTable();
        MakeAddWheelChairTable();
        MakeAddProjectsTable();
        MakeAddAccountTable();
        MakeAddAmbulanceusageTable();

        if ($("#addNewDistrict").length) {
            $("#country_id").select2();
        }
        if ($("#addNewVillages").length) {
            $("#village_district_id").select2();
        }
        if ($("#addNewWorkplace").length) {
            $("#village_id").select2();
        }
        if ($("#DistrictsPage").length) {
            $("#country_id").select2();
        }
        if ($("#VillagesPage").length) {
            $("#village_district_id").select2();
        }
        if ($("#WorkplacesPage").length) {
            $("#village_id").select2();
        }

        // Ambulance
        if ($("#AddAmbulanceModal").length) {
            $("#ambulance_village").select2();
            $("#ambulance_workplace").select2();
            $("#ambulance_sponsor").select2();
            $("#ambulance_feild").select2();
        }

        if ($("#EditAmbulanceModal").length) {
            $("#ambulanceVillage_id").select2();
            $("#ambulanceworkplace_id").select2();
            $("#ambulanceSponsor_id").select2();
            $("#ambulancefeid_ld").select2();
        }

        // Ambulance Usage
        if ($("#AddAmbulancusageeModal").length) {
            $("#village_id").select2();
            $("#ambulance_id").select2();
        }

        // Wheelchair
        if ($("#AddWheelChairModal").length) {
            $("#wheelchair_field_id").select2();
            $("#wheelchair_sponsor_id").select2();
        }

        // Projects
        if ($("#AddProjectModal").length) {
            $("#ambulance_feild").select2();
            $("#field_id").select2();
            $("#projects_sponsor").select2();
            $("#projects_village").select2();
        }
        // Prospects
        if ($("#AddProspectModal").length) {
            $("#prospects_sponsor").select2();
            $("#prospects_feild").select2();
        }

        // Dashboard page
        if ($("#DashboardPage").length) {
            MakeAmbulanceGoogleMap();
            MakeWheelchairGoogleMap();
            MakeProjectsGoogleMap();
            MakeProspectsGoogleMap();
        }

        // User Change Password
        $("form#changePasswordForm").submit(function (e) {
            // Check for Password Match
            let NewPassword = $("#newPassword").val();
            let ConfirmPassword = $("#confirmPassword").val();
            if (NewPassword === ConfirmPassword) {
                $("#changePasswordError").hide();
            } else {
                $("#changePasswordError").show();
                e.preventDefault(e);
            }
        });

        // Update Profile Page
        if ($("#updateProfilePage").length) {
            $("#phone").mask('999-999-9999');
                    @if(isset($Profile[0]))
            let today = new Date();
            let DOB = new Date('{{$Profile[0]->dob}}').toISOString().split('T')[0];
            $("#dob").val(DOB);
            @endif

            $("#userProfileUpdate").on("change", function (e) {
                let fileName = document.getElementById("userProfileUpdate").value;
                let idxDot = fileName.lastIndexOf(".") + 1;
                let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                if (extFile === "jpeg" || extFile === "png" || extFile === "jpg" || extFile === "JPEG" || extFile === "PNG" || extFile === "JPG") {
                    $("#userProfileUpdatePreview").attr('src', URL.createObjectURL(e.target.files[0]));
                } else {
                    $("#userProfileUpdate").val('');
                }
            });
        }

        $("#userProfileUpdate").on("change", function (e) {
            let fileName = document.getElementById("userProfileUpdate").value;
            let idxDot = fileName.lastIndexOf(".") + 1;
            let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile === "jpeg" || extFile === "png" || extFile === "jpg" || extFile === "JPEG" || extFile === "PNG" || extFile === "JPG") {
                $("#userProfileUpdatePreview").attr('src', URL.createObjectURL(e.target.files[0]));
            } else {
                $("#userProfileUpdate").val('');
            }
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function PasswordConfirmPasswordCheck() {
        let Password = $("#newPassword").val();
        let ConfirmPassword = $("#confirmPassword").val();
        if(Password !== ConfirmPassword){
            $("#saveAccountBtn").attr('disabled', true);
            $("#error-alert").text("Password and conform password not match!").show();
        }
        else{
            $("#saveAccountBtn").attr('disabled', false);
            $("#error-alert").text("").hide();
        }
    }

    /* Field Officers - Start  */
    function MakeFieldOfficersTable() {
        <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/field-officer/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/field-officer/all');
            }
            ?>
        if ($("#admin_fieldofficers_table").length) {
            $("#admin_fieldofficers_table").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'id'
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Field Officers - End  */

    /* Sponsors - Start  */
    function MakeSponsorsTable() {
        if ($("#admin_sponsors_table").length) {
            <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/sponsors/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/sponsors/all');
            }
            ?>
            $("#admin_sponsors_table").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'id'
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Sponsors - End  */

    /* Country - Start  */
    function MakeCountriesTable() {
        <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/countries/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/countries/all');
            }
            ?>
        if ($("#admin_countries_table").length) {
            $("#admin_countries_table").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'id'
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'country_code'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Sponsors - End  */

    /* Districts - Start  */
    function MakeDistrictsTable() {
        if ($("#admin_districts_table").length) {
            <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/districts/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/districts/all');
            }
            ?>
            $("#admin_districts_table").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'id'
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'country_id'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Sponsors - End  */

    /* Villages - Start  */
    function MakevillagesTable() {
        if ($("#admin_villages_table").length) {
            <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/villages/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/villages/all');
            }
            ?>
            $("#admin_villages_table").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'id'
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'district_id'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Villages - End  */

    function MakeWorkPlacesTable() {
        if ($("#admin_workplaces_table").length) {
            <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/workplaces/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/workplaces/all');
            }
            ?>
            $("#admin_workplaces_table").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'id'
                },
                    {
                        data: 'name'
                    },
                    {
                        data: 'village_id'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Field villages - End  */

    /* Field Ambulance - End  */
    function MakeAmbulanceTable() {
        <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/dashboard/ambulances/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/dashboard/ambulances/all');
            }
            ?>
        if ($("#admin_ambulance").length) {
            $("#admin_ambulance").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'name'
                },
                    {
                        data: 'village'
                    },
                    {
                        data: 'latest_repair'
                    },
                    {
                        data: 'next_repair'
                    },
                    {
                        data: 'latitude'
                    },
                    {
                        data: 'longitude'
                    },
                    {
                        data: 'workplace'
                    },
                    {
                        data: 'sponsor'
                    },
                    {
                        data: 'field_officer'
                    },
                    {
                        data: 'action'
                    }
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Ambulance - End  */

    /*Wheelchairs - End  */
    function MakeAddProjectsTable() {
        <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/projects/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/projects/all');
            }
            ?>
        if ($("#admin_projects").length) {
            $("#admin_projects").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url}}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'Title'
                },
                    {
                        data: 'Start date'
                    },
                    {
                        data: 'End date'
                    },
                    {
                        data: 'Latitude'
                    },
                    {
                        data: 'Longitude'
                    },
                    {
                        data: 'Sponsor'
                    },
                    {
                        data: 'Feildofficer'
                    },
                    {
                        data: 'Description'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Wheelchair - End  */

    /* Projects - End  */
    function MakeAddWheelChairTable() {
        <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/wheelchair/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/wheelchair/all');
            }
            ?>
        if ($("#admin_wheelchair").length) {
            $("#admin_wheelchair").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'Name'
                },
                    {
                        data: 'Latitude'
                    },
                    {
                        data: 'Longitude'
                    },
                    {
                        data: 'Latestrepair'
                    },
                    {
                        data: 'Nextrepair'
                    },
                    {
                        data: 'Sponsor'
                    },
                    {
                        data: 'FieldOfficer'
                    },
                    {
                        data: 'action'
                    },

                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Wheelchair - End */

    /* Prospects - End */
    function MakeAddProspectsTable() {
        <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/prospects/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/prospects/all');
            }
            ?>
        if ($("#admin_prospect").length) {
            $("#admin_prospect").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [{
                    data: 'Title'
                },
                    {
                        data: 'Description'
                    },
                    {
                        data: 'Start date'
                    },
                    {
                        data: 'End date'
                    },
                    {
                        data: 'Latitude'
                    },
                    {
                        data: 'Longitude'
                    },
                    {
                        data: 'Sponsor'
                    },
                    {
                        data: 'Feildofficer'
                    },
                    {
                        data: 'action'
                    },
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Field wheelchair - End  */

    /* Field prospects - End  */
    function MakeAddAccountTable() {
        if ($("#admin_accounts").length) {
            $("#admin_accounts").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ url('admin/accounts/all') }}",
                    "type": "POST",
                },
                'columns': [
                    {
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'logged_in'
                    },
                    {
                        data: 'role'
                    },

                    {
                        data: 'status'
                    },

                    {
                        data: 'action'
                    }
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Field wheelchair - End  */

    function MakeAddAmbulanceusageTable() {
        <?php
            if (session()->get('user_role') == 1) {
                $Url = '';
                $Url = url('admin/ambulance/usage/all');
            } elseif (session()->get('user_role') == 2) {
                $Url = '';
                $Url = url('reader/ambulance/usage/all');
            }
            ?>
        if ($("#admin_ambulance_usage").length) {
            $("#admin_ambulance_usage").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "bPaginate": true,
                "ordering": true,
                "pageLength": 50,
                "lengthMenu": [
                    [50, 100, 200, 400],
                    ['50', '100', '200', '400']
                ],
                "ajax": {
                    "url": "{{ $Url }}",
                    "type": "POST",
                },
                'columns': [
                    {
                        data: 'id'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'patient_name'
                    },
                    {
                        data: 'age_of_patient'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'village'
                    },
                    {
                        data: 'health_facility'
                    },
                    {
                        data: 'time_of_departure'
                    },
                    {
                        data: 'type_of_case'
                    },
                    {
                        data: 'deceased'
                    },
                    {
                        data: 'ambulance'
                    },
                    {
                        data: 'action'
                    }
                ],
                'order': [0, 'desc']
            });
        }
    }

    /* Field wheelchair - End  */

    function deleteFieldOfficer(e) {
        let id = e.split('_')[1];
        $("#deleteFieldId").val(id);
        $("#deleteFieldModal").modal('toggle');
    }

    function deleteSponsorOfficer(e) {
        let id = e.split('_')[1];
        $("#deleteSponsordId").val(id);
        $("#deleteSponsorModal").modal('toggle');
    }

    function deleteCountry(e) {
        let id = e.split('_')[1];
        $("#deleteCountryId").val(id);
        $("#deleteCountryModal").modal('toggle');
    }

    function deleteDistricts(e) {
        let id = e.split('_')[1];
        $("#deleteDistrictId").val(id);
        $("#deleteDistrictModal").modal('toggle');
    }

    function deleteVillages(e) {
        let id = e.split('_')[1];
        $("#deleteVillageID").val(id);
        $("#deleteVillageModal").modal('toggle');
    }

    function deleteWorkPlaces(e) {
        let id = e.split('_')[1];
        $("#deleteWorkID").val(id);
        $("#deleteWorkModal").modal('toggle');
    }

    function editFieldOfficer(e) {
        let id = e.split('_')[1];
        let name = e.split('_')[2];
        $("#editFieldId").val(id);
        $("#editfieldofficername").val(name);
        $("#editFieldOfficersModal").modal('toggle');
    }

    function editSponser(e) {
        let id = e.split('_')[1];
        let name = e.split('_')[2];
        $("#editSponsorsId").val(id);
        $("#editsponsername").val(name);
        $("#editSponsorsModal").modal('toggle');
    }

    function editCountry(e) {
        let id = e.split('_')[1];
        let country_name = e.split('_')[2];
        let country_code = e.split('_')[3];
        $("#editCountryId").val(id);
        $("#editcountryname").val(country_name);
        $("#editcountrycode").val(country_code);
        $("#editCountryModal").modal('toggle');
    }

    function editdistricts(e) {
        let id = e.split('_')[1];
        let name = e.split('_')[2];
        let country = e.split('_')[3];
        $("#editDistrictId").val(id);
        $("#editdistrictname").val(name);
        let options = '<option value="">Select Country</option>';
        for (let i = 0; i < countries.length; i++) {
            if (country == countries[i]['id']) {
                options +=
                    '<option value="' + countries[i]['id'] + '" selected>' + countries[i]['name'] + '</option>';
            } else {
                options +=
                    '<option value="' + countries[i]['id'] + '">' + countries[i]['name'] + '</option>';
            }
        }
        $("#country_id").html(options);
        $("#editDistrictModal").modal('toggle');
    }

    function editVillages(e) {
        let id = e.split('_')[1];
        let name = e.split('_')[2];
        let district = e.split('_')[3];
        $("#editVillageId").val(id);
        $("#editvillagename").val(name);
        let options = '<option value="">Select District</option>';
        for (let i = 0; i < districts.length; i++) {
            if (district == districts[i]['id']) {
                options +=
                    '<option value="' + districts[i]['id'] + '" selected>' + districts[i]['name'] + '</option>';
            } else {
                options +=
                    '<option value="' + districts[i]['id'] + '">' + districts[i]['name'] + '</option>';
            }
        }
        $("#village_district_id").html(options);
        $("#editVillageModal").modal('toggle');
    }

    function editWorkPlace(e) {
        let id = e.split('_')[1];
        let name = e.split('_')[2];
        let village = e.split('_')[3];
        $("#editWorkPlaceId").val(id);
        $("#editworkplacename").val(name);
        let options = '<option value="">Select Village</option>';
        for (let i = 0; i < villages.length; i++) {
            if (village == villages[i]['id']) {
                options +=
                    '<option value="' + villages[i]['id'] + '" selected>' + villages[i]['name'] + '</option>';
            } else {
                options +=
                    '<option value="' + villages[i]['id'] + '">' + villages[i]['name'] + '</option>';
            }
        }
        $("#village_id").html(options);
        $("#editWorkplaceModal").modal('toggle');
    }

    // Dahboard Functionality
    $('#add_ambulance').click(function () {
        $('#AddAmbulanceModal').toggle();
    });

    /* Ambulance  Section - Start */
    function deleteAmbulance(e) {
        let id = e.split('_')[1];
        $("#deleteAmbulanceId").val(id);
        $("#deleteAmbulanceModal").modal('toggle');
    }

    function confirmDeleteAmbulance() {
            <?php
            $Url = '';
            $Url = url('admin/delete/ambulance');
            ?>
        let id = $('#deleteAmbulanceId').val();
        $.ajax({
            type: "post",
            url: "{{ $Url }}",
            data: {
                AmbulanceId: id
            }
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $('#admin_ambulance').DataTable().ajax.reload();
                $("#deleteAmbulanceModal").modal('hide');
            } else {
                $('#admin_ambulance').DataTable().ajax.reload();
            }
        });
    }

    /* Ambulance Section - End */

    /* Wheelchair  Section - Start */
    function deleteWheelchair(e) {
        let id = e.split('_')[1];
        $("#deleteWheelchairId").val(id);
        $("#deleteWheelchairModal").modal('toggle');
    }

    function confirmDeleteWheelchair() {
            <?php
            $Url = '';
            $Url = url('admin/delete/wheelchair');
            ?>
        let id = $('#deleteWheelchairId').val();
        $.ajax({
            type: "post",
            url: "{{ $Url }}",
            data: {
                WheelchairId: id
            }
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $('#admin_wheelchair').DataTable().ajax.reload();
                $("#deleteWheelchairModal").modal('hide');
            } else {
                $('#admin_wheelchair').DataTable().ajax.reload();
            }
        });
    }

    /* Wheelchair Section - End */

    /* Wheelchair Section - Start */
    function deleteProjects(e) {
        let id = e.split('_')[1];
        $("#deleteProjectsId").val(id);
        $("#deleteProjectsModal").modal('toggle');
    }

    function confirmDeleteProject() {
            <?php
            $Url = '';
            $Url = url('admin/delete/projects');
            ?>
        let id = $('#deleteProjectsId').val();
        $.ajax({
            type: "post",
            url: "{{ $Url }}",
            data: {
                ProjectId: id
            }
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $('#admin_projects').DataTable().ajax.reload();
                $("#deleteProjectsModal").modal('hide');
            } else {
                $('#admin_projects').DataTable().ajax.reload();
            }
        });
    }

    // Ambulance Stored
    $('#add-Ambulance').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/ambulances/stored');
        ?>
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ $Url }}",
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $("#AddAmbulanceModal").modal('hide');
                if (jQuery.trim(data) === 'Success') {
                    $('#admin_ambulance').DataTable().ajax.reload();
                } else {
                    $('#admin_ambulance').DataTable().ajax.reload();
                }
                MakeAmbulanceGoogleMap();
            }
        });
    });

    // WheelChair Stored
    $('#wheelchairStore').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/wheelchair/store');
        ?>
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ $Url }}",
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $("#AddWheelChairModal").modal('hide');
                if (jQuery.trim(data) === 'Success') {
                    $('#admin_wheelchair').DataTable().ajax.reload();
                } else {
                    $('#admin_wheelchair').DataTable().ajax.reload();
                }
                MakeWheelchairGoogleMap();
            }
        });
    });

    // Project Stored
    $('#projectForm').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/projects/store');
        ?>
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ $Url }}",
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $("#AddProjectModal").modal('hide');
                if (jQuery.trim(data) === 'Success') {
                    $('#admin_projects').DataTable().ajax.reload();
                } else {
                    $('#admin_projects').DataTable().ajax.reload();
                }
                MakeProjectsGoogleMap();
            }
        });
    });

    // Proscpects Stored
    $('#prospectForm').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/prospects/store');
        ?>
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ $Url }}",
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $("#AddProspectModal").modal('hide');
                if (jQuery.trim(data) === 'Success') {

                    $('#admin_prospect').DataTable().ajax.reload();

                } else {
                    $('#admin_prospect').DataTable().ajax.reload();
                }
            }
        });
    });

    function deleteprospect(e) {
        let id = e.split('_')[1];
        $("#deleteProspectsId").val(id);
        $("#deleteProspectsModal").modal('toggle');
    }

    function confirmDeleteProspects() {
            <?php
            $Url = '';
            $Url = url('admin/delete/prospects');
            ?>
        let id = $('#deleteProspectsId').val();
        $.ajax({
            type: "post",
            url: "{{ $Url }}",
            data: {
                ProspectsId: id
            }
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $('#admin_prospect').DataTable().ajax.reload();
                $("#deleteProspectsModal").modal('hide');
            } else {
                $('#admin_prospect').DataTable().ajax.reload();
            }
        });
    }

    function editAmbulance(e) {
        $("#EditAmbulanceModal").modal('toggle');
        let id = e.split('_')[1];
        let name = e.split('_')[2];
        let latitude = e.split('_')[3];
        let longitude = e.split('_')[4];
        let village_id = e.split('_')[5];
        let sponsor_id = e.split('_')[6];
        let workplace_id = e.split('_')[7];
        let field_id = e.split('_')[8];
        var next_repair = new Date().toISOString().split('T')[0];
        var lastest_repair = new Date().toISOString().split('T')[0];
        $("#editAmbulanceId").val(id);
        $("#ambulanceName").val(name);
        $("#ambulanceLatitude_id").val(latitude);
        $("#ambulanceLongitutde_id").val(longitude);
        $("#ambulanceNext_id").val(next_repair);
        $("#ambulanceRepair_id").val(lastest_repair);
        let options = '<option value="" disabled>Select Village</option>';
        for (let i = 0; i < villages.length; i++) {
            if (village_id == villages[i]['id']) {
                options +=
                    '<option value="' + villages[i]['id'] + '" selected>' + villages[i]['name'] + '</option>';
            } else {
                options +=
                    '<option value="' + villages[i]['id'] + '">' + villages[i]['name'] + '</option>';
            }
        }
        $("#ambulanceVillage_id").html(options);

        let sponsor_options = '<option value="" disabled>Select Sponsor</option>';
        for (let i = 0; i < sponsors.length; i++) {
            if (sponsor_id == sponsors[i]['id']) {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '" selected>' + sponsors[i]['name'] + '</option>';
            } else {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '">' + sponsors[i]['name'] + '</option>';
            }
        }
        $("#ambulanceSponsor_id").html(sponsor_options);

        let feild_options = '<option value="" disabled>Select Field Officer</option>';
        for (let i = 0; i < feildOfficers.length; i++) {
            if (field_id == feildOfficers[i]['id']) {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '" selected>' + feildOfficers[i]['name'] + '</option>';
            } else {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '">' + feildOfficers[i]['name'] + '</option>';
            }
        }
        $("#ambulancefeid_ld").html(feild_options);

        let workplace_options = '<option value="" disabled>Select Workplace</option>';
        for (let i = 0; i < workplaces.length; i++) {
            if (workplace_id == workplaces[i]['id']) {
                workplace_options +=
                    '<option value="' + workplaces[i]['id'] + '" selected>' + workplaces[i]['name'] + '</option>';
            } else {
                workplace_options +=
                    '<option value="' + workplaces[i]['id'] + '">' + workplaces[i]['name'] + '</option>';
            }
        }
        $("#ambulanceworkplace_id").html(workplace_options);
    }

    $('#edit-Ambulance').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/update/ambulance');
        ?>
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ $Url }}",
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $("#EditAmbulanceModal").modal('hide');
                if (jQuery.trim(data) === 'Success') {
                    $('#admin_ambulance').DataTable().ajax.reload();
                } else {
                    $('#admin_ambulance').DataTable().ajax.reload();
                }
                MakeAmbulanceGoogleMap();
            }
        });
    });

    if ($("#EditAmbulanceModal").length) {
        $("#edidWheelchair_id").select2();
    }
    if ($("#EditAmbulanceModal").length) {
        $("#editSponsor_id").select2();
    }

    /*  Edit Wheelchair */
    function editWheelchair(e) {
        $("#EditWheelChairModal").modal('toggle');
        let id = e.split('_')[1];
        let name = e.split('_')[2];
        let sponsor_id = e.split('_')[3];
        let field_id = e.split('_')[4];
        let latitude = e.split('_')[5];
        let longitude = e.split('_')[6];
        var next_repair = new Date().toISOString().split('T')[0];
        var lastest_repair = new Date().toISOString().split('T')[0];
        $("#editWheelchairId").val(id);
        $("#wheel_name").val(name);
        let sponsor_options = '<option value="" disabled>Select Sponsor</option>';
        for (let i = 0; i < sponsors.length; i++) {
            if (sponsor_id == sponsors[i]['id']) {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '" selected>' + sponsors[i]['name'] + '</option>';
            } else {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '">' + sponsors[i]['name'] + '</option>';
            }
        }
        $("#editSponsor_id").html(sponsor_options);
        let feild_options = '<option value="" disabled>Select Field Officer</option>';
        for (let i = 0; i < feildOfficers.length; i++) {
            if (field_id == feildOfficers[i]['id']) {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '" selected>' + feildOfficers[i]['name'] + '</option>';
            } else {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '">' + feildOfficers[i]['name'] + '</option>';
            }
        }
        $("#edidWheelchair_id").html(feild_options);
        $("#wheel_latitude").val(latitude);
        $("#wheel_lonfitude").val(longitude);
        $("#wheel_nextrepair").val(next_repair);
        $("#wheel_latestrepair ").val(lastest_repair);
        <?php
        $Url = '';
        $Url = url('admin/update/wheelchair');
        ?>
        $('#EdidWheelChairForm').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ $Url }}",
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    $("#EditWheelChairModal").modal('hide');
                    if (jQuery.trim(data) === 'Success') {
                        $('#admin_wheelchair').DataTable().ajax.reload();
                    } else {
                        $('#admin_wheelchair').DataTable().ajax.reload();
                    }
                    MakeWheelchairGoogleMap();
                }
            });
        });

        if ($("#EditAmbulanceModal").length) {
            $("#ambulanceVillage_id").select2();
        }
        if ($("#EditAmbulanceModal").length) {
            $("#ambulanceworkplace_id").select2();
        }
        if ($("#EditAmbulanceModal").length) {
            $("#ambulanceSponsor_id").select2();
        }
        if ($("#EditAmbulanceModal").length) {
            $("#ambulancefeid_ld").select2();
        }
    }

    /*  Close Wheelchair */

    /*  Edit Prospects */
    function editProject(e) {
        $("#EditProjectModal").modal('toggle');
        let id = e.split('_')[1];
        let title = e.split('_')[2];
        let start_time = new Date().toISOString().split('T')[0];
        let end_time = new Date().toISOString().split('T')[0];
        let sponsor_id = e.split('_')[5];
        let field_id = e.split('_')[6];
        let village_id = e.split('_')[7];
        let latitude = e.split('_')[8];
        let longitude = e.split('_')[9];
        let description = e.split('_')[10];
        $("#project_id").val(id);
        $("#project_title").val(title);
        $("#project_startdate").val(start_time);
        $("#project_enddate").val(end_time);
        let sponsor_options = '<option value="">Select Sponsor</option>';
        for (let i = 0; i < sponsors.length; i++) {
            if (sponsor_id == sponsors[i]['id']) {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '" selected>' + sponsors[i]['name'] + '</option>';
            } else {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '">' + sponsors[i]['name'] + '</option>';
            }
        }
        $("#editProjectSponsor_id").html(sponsor_options);
        let feild_options = '<option value="">Select Feild Officer</option>';
        for (let i = 0; i < feildOfficers.length; i++) {
            if (field_id == feildOfficers[i]['id']) {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '" selected>' + feildOfficers[i]['name'] + '</option>';
            } else {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '">' + feildOfficers[i]['name'] + '</option>';
            }
        }
        $("#editProjectsFeild_id").html(feild_options);
        let villahg_ption = '<option value="">Select Village</option>';
        for (let i = 0; i < villages.length; i++) {
            if (village_id == villages[i]['id']) {
                villahg_ption +=
                    '<option value="' + villages[i]['id'] + '" selected>' + villages[i]['name'] + '</option>';
            } else {
                villahg_ption +=
                    '<option value="' + villages[i]['id'] + '">' + villages[i]['name'] + '</option>';
            }
        }
        $("#projects_village").html(villahg_ption);
        $("#project_latitude").val(latitude);
        $("#project_longitude").val(longitude);
        $("#project_des").val(description);
        <?php
        $Url = '';
        $Url = url('admin/update/projects');
        ?>
        $('#projectEditForm').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ $Url }}",
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    $("#EditProjectModal").modal('hide');
                    if (jQuery.trim(data) === 'Success') {
                        $('#admin_projects').DataTable().ajax.reload();
                    } else {
                        $('#admin_projects').DataTable().ajax.reload();
                    }
                    MakeProjectsGoogleMap();
                }
            });
        });

        if ($("#EditProjectModal").length) {
            $("#editProjectSponsor_id").select2();
        }

        if ($("#EditProjectModal").length) {
            $("#projects_village").select2();
        }
        if ($("#EditProjectModal").length) {
            $("#editProjectsFeild_id").select2();
        }
    }

    /*  Close Prospects */

    /*  Edit Prospects */
    function editProspect(e) {
        $("#EditProspectModal").modal('toggle');
        let id = e.split('_')[1];
        let title = e.split('_')[2];
        let description = e.split('_')[3];
        let latitude = e.split('_')[4];
        let longitude = e.split('_')[5];
        let sponsor_id = e.split('_')[8];
        let field_id = e.split('_')[9];
        let start_time = new Date().toISOString().split('T')[0];
        let end_time = new Date().toISOString().split('T')[0];
        $("#prospect_id").val(id);
        $("#prospectEdit_title").val(title);
        $("#prospectEdit_description").val(description);
        $("#prospectEdit_lat").val(latitude);
        $("#prospectEdit_long").val(longitude);
        $("#prospectEdit_startdate").val(start_time);
        $("#prospectEdit_enddate").val(end_time);
        let sponsor_options = '<option value="" disabled>Select Sponsor</option>';
        for (let i = 0; i < sponsors.length; i++) {
            if (sponsor_id == sponsors[i]['id']) {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '" selected>' + sponsors[i]['name'] + '</option>';
            } else {
                sponsor_options +=
                    '<option value="' + sponsors[i]['id'] + '">' + sponsors[i]['name'] + '</option>';
            }
        }
        $("#prospectEdit_sponsorID").html(sponsor_options);
        let feild_options = '<option value="">Select Field Officer</option>';
        for (let i = 0; i < feildOfficers.length; i++) {
            if (field_id == feildOfficers[i]['id']) {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '" selected>' + feildOfficers[i]['name'] + '</option>';
            } else {
                feild_options +=
                    '<option value="' + feildOfficers[i]['id'] + '">' + feildOfficers[i]['name'] + '</option>';
            }
        }
        $("#prospectEdit_feildID").html(feild_options);
        <?php
        $Url = '';
        $Url = url('admin/update/prospects');
        ?>
        $('#editProspectForm').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{ $Url }}",
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    $("#EditProspectModal").modal('hide');
                    if (jQuery.trim(data) === 'Success') {
                        $('#admin_prospect').DataTable().ajax.reload();
                    } else {
                        $('#admin_prospect').DataTable().ajax.reload();
                    }
                    MakeProspectsGoogleMap();
                }
            });
        });

        if ($("#EditProjectModal").length) {
            $("#prospectEdit_sponsorID").select2();
        }

        if ($("#EditProjectModal").length) {
            $("#prospectEdit_feildID").select2();
        }
    }

    /*  Ambulance usage  */
    $('#addAmbulanceUsage').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/ambulance/usage/store');
        ?>
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{$Url}}",
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $("#AddAmbulancusageeModal").modal('hide');
                if (jQuery.trim(data) === 'Success') {
                    $('#admin_ambulance_usage').DataTable().ajax.reload();
                } else {
                    $('#admin_ambulance_usage').DataTable().ajax.reload();
                }
            }
        });
    });

    // Delete Logic
    function deleteAmbulanceUsage(e) {
        let id = e.split('_')[1];
        $("#deleteAmbulanceUsageId").val(id);
        $("#deleteAmbulanceUsageModal").modal('toggle');
    }

    function confirmDeleteAmbulanceUsage() {
            <?php
            $Url = '';
            $Url = url('admin/delete/ambulance/usage');
            ?>
        let id = $('#deleteAmbulanceUsageId').val();
        $.ajax({
            type: "post",
            url: "{{$Url}}",
            data: {
                deleteAmbulanceUsageId: id
            }
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $('#admin_ambulance_usage').DataTable().ajax.reload();
                $("#deleteAmbulanceUsageModal").modal('hide');
            } else {
                $('#admin_ambulance_usage').DataTable().ajax.reload();
            }
        });
    }

    function editAmbulanceUsage(e) {
        $("#EditAmbulancusageeModal").modal('toggle');
        let id = e.split('_')[1];
        let date = e.split('_')[2];
        let name = e.split('_')[3];
        let age_of_patient = e.split('_')[4];
        let gender = e.split('_')[5];
        let village_id = e.split('_')[6];
        let health_facility = e.split('_')[7];
        let time_of_departure = e.split('_')[8];
        let type_of_case = e.split('_')[9];
        let deceased = e.split('_')[10];
        let ambulance_id = e.split('_')[11];
        $("#editAmbulanceusageId").val(id);
        $("#au_date").val(date);
        $("#au_name").val(name);
        $("#au_patient").val(age_of_patient);
        if (gender == "male") {
            $('#au_male').prop('checked', true);
        } else {
            $('#au_female').prop('checked', true);
        }
        let au_options = '<option value="">Select Village</option>';
        for (let i = 0; i < villages.length; i++) {
            if (village_id == villages[i]['id']) {
                au_options +=
                    '<option value="' + villages[i]['id'] + '" selected>' + villages[i]['name'] + '</option>';
            } else {
                au_options +=
                    '<option value="' + villages[i]['id'] + '">' + villages[i]['name'] + '</option>';
            }
        }
        $("#au_village").html(au_options);
        $("#au_health").val(health_facility);
        $("#au_tod").val(time_of_departure);
        $("#au_toc").val(type_of_case);
        if (deceased === 'Yes') {
            $('#au_dea').prop('checked', true);
        } else {
            $('#au_dea').prop('checked', false);
        }
        let au_ambulanceUsage = '<option value="">Select Ambulance</option>';
        for (let i = 0; i < ambulances.length; i++) {
            if (ambulance_id == ambulances[i]['id']) {
                au_ambulanceUsage +=
                    '<option value="' + ambulances[i]['id'] + '" selected>' + ambulances[i]['name'] + '</option>';
            } else {
                au_ambulanceUsage +=
                    '<option value="' + ambulances[i]['id'] + '">' + ambulances[i]['name'] + '</option>';
            }
        }
        $("#au_ambulance").html(au_ambulanceUsage);
    }

    <?php
    $Url = '';
    $Url = url('admin/update/ambulance/usage');
    ?>
    $('#editAmbulanceUsageForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ $Url }}",
            type: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                $("#EditAmbulancusageeModal").modal('hide');
                if (jQuery.trim(data) === 'Success') {
                    $('#admin_ambulance_usage').DataTable().ajax.reload();
                } else {
                    $('#admin_ambulance_usage').DataTable().ajax.reload();
                }
            }
        });
    });

    if ($("#EditAmbulancusageeModal").length) {
        $("#au_village").select2();
    }

    if ($("#EditAmbulancusageeModal").length) {
        $("#au_ambulance").select2();
    }
    /*  Ambulance usage  */

    /* Dashboard Google Maps - Start */
    function MakeAmbulanceGoogleMap()
    {
      <?php
      $Url = '';
      $Url = url('/ambulances/all');
      ?>
      $.ajax({
          url: "{{ $Url }}",
          type: 'POST',
          contentType: false,
          processData: false,
          success: function (data) {
            var locations = JSON.parse(data);
            var map = new google.maps.Map(document.getElementById('mymap'), {
              zoom: 6,
              center: new google.maps.LatLng(52.19593546200227, 5.357714603695409),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();
            var marker, i;

            for (i = 0; i < locations.length; i++) {
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i]['latitude'], locations[i]['longitude']),
                map: map
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
          }
      });
    }

    function MakeWheelchairGoogleMap()
    {
      <?php
      $Url = '';
      $Url = url('/wheelchairs/all');
      ?>
      $.ajax({
          url: "{{ $Url }}",
          type: 'POST',
          contentType: false,
          processData: false,
          success: function (data) {
            var wheelchair_markers = JSON.parse(data);
            var map = new google.maps.Map(document.getElementById('wheechairmap'), {
              zoom: 6,
              center: new google.maps.LatLng(52.19593546200227, 5.357714603695409),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();
            var marker, i;

            for (i = 0; i < wheelchair_markers.length; i++) {
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(wheelchair_markers[i]['latitude'], wheelchair_markers[i]['longitude']),
                map: map
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(wheelchair_markers[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
          }
      });
    }

    function MakeProjectsGoogleMap()
    {
      <?php
      $Url = '';
      $Url = url('/projects/all');
      ?>
      $.ajax({
          url: "{{ $Url }}",
          type: 'POST',
          contentType: false,
          processData: false,
          success: function (data) {
            var projects_markers = JSON.parse(data);
            var map = new google.maps.Map(document.getElementById('projecttMap'), {
              zoom: 6,
              center: new google.maps.LatLng(52.19593546200227, 5.357714603695409),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();
            var marker, i;

            for (i = 0; i < projects_markers.length; i++) {
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(projects_markers[i]['latitude'], projects_markers[i]['longitude']),
                map: map
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
          }
      });
    }

    function MakeProspectsGoogleMap()
    {
      <?php
      $Url = '';
      $Url = url('/prospects/all');
      ?>
      $.ajax({
          url: "{{ $Url }}",
          type: 'POST',
          contentType: false,
          processData: false,
          success: function (data) {
            var prospect_markers = JSON.parse(data);
            var map = new google.maps.Map(document.getElementById('prospecttMap'), {
              zoom: 6,
              center: new google.maps.LatLng(52.19593546200227, 5.357714603695409),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();
            var marker, i;

            for (i = 0; i < prospect_markers.length; i++) {
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(prospect_markers[i]['latitude'], prospect_markers[i]['longitude']),
                map: map
              });

              google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                  infowindow.setContent(locations[i][0]);
                  infowindow.open(map, marker);
                }
              })(marker, i));
            }
          }
      });
    }
    /* Dashboard Google Maps - End

    /*  Close Prospects */
    $('#add-accounts').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/store/accounts');
        ?>
        e.preventDefault();
        let Email = $("#add_email").val();
        let FirstName = $("#firstName").val();
        let LastName = $("#lastName").val();
        if (Email === '') {
            $("#_missingEmailError").html('Email Required');
            return;
        } else if (FirstName === '') {
            $("#_missingFirstNameError").html('First Name Required');
            return;
        } else if (LastName === '') {
            $("#_missingLastNameError").html('Last Name Required');
            return;
        } else {
            let formData = new FormData(this);
            $.ajax({
                url: "{{$Url}}",
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    $("#AddAccountModal").modal('hide');
                    if (jQuery.trim(data) === 'Success') {
                        $('#admin_accounts').DataTable().ajax.reload();
                        $('#add-accounts')[0].reset();
                        $("#_missingEmailError").html('');
                        $("#_missingFirstNameError").html('');
                        $("#_missingLastNameError").html('');
                    } else {
                        $('#admin_accounts').DataTable().ajax.reload();
                        $('#add-accounts')[0].reset();
                        $("#_missingEmailError").html('');
                        $("#_missingFirstNameError").html('');
                        $("#_missingLastNameError").html('');
                    }
                }
            });
        }
    });

    function ChangeEmailAddress() {
        $("#_missingEmailError").html('');
    }

    function ChangeFirstName() {
        $("#_missingFirstNameError").html('');
    }

    function ChangeLastName() {
        $("#_missingLastNameError").html('');
    }

    // Delete Accounts
    function deleteAccount(e) {
        let id = e.split('_')[1];
        $("#deleteAccountId").val(id);
        $("#deleteAccounteModal").modal('toggle');
    }

    function confirmDeleteAccount() {
            <?php
            $Url = '';
            $Url = url('admin/accounts/delete');
            ?>
        let id = $('#deleteAccountId').val();
        $.ajax({
            type: "post",
            url: "{{ $Url }}",
            data: {
                AccountId: id
            }
        }).done(function (data) {
            if (jQuery.trim(data) === 'Success') {
                $('#admin_accounts').DataTable().ajax.reload();
                $("#deleteAccounteModal").modal('hide');
            } else {
                $('#admin_accounts').DataTable().ajax.reload();
            }
        });
    }

    // Edit
    $('#edit-accounts').submit(function (e) {
        <?php
        $Url = '';
        $Url = url('admin/update/accounts');
        ?>
        e.preventDefault();
        let Email = $("#account_email").val();
        let FirstName = $("#account_firstname").val();
        let LastName = $("#account_lastName").val();
        if (Email === '') {
            $("#_editMissingEmailError").html('Email Required');
            return;
        } else if (FirstName === '') {
            $("#_editMissingFirstNameError").html('First Name Required');
            return;
        } else if (LastName === '') {
            $("#_editMissingLastNameError").html('Last Name Required');
            return;
        } else {
            let formData = new FormData(this);
            $.ajax({
                url: "{{$Url}}",
                type: 'POST',
                dataType: 'JSON',
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    $("#editAccountModal").modal('hide');
                    if (jQuery.trim(data) === 'Success') {
                        $('#admin_accounts').DataTable().ajax.reload();
                        $('#edit-accounts')[0].reset();
                        $("#_editMissingEmailError").html('');
                        $("#_editMissingFirstNameError").html('');
                        $("#_editMissingLastNameError").html('');
                    } else {
                        $('#admin_accounts').DataTable().ajax.reload();
                        $('#edit-accounts')[0].reset();
                        $("#_editMissingEmailError").html('');
                        $("#_editMissingFirstNameError").html('');
                        $("#_editMissingLastNameError").html('');
                    }
                }
            });
        }
    });

    function ChangeEditEmailAddress() {
        $("#_editMissingEmailError").html('');
    }

    function ChangeEditFirstName() {
        $("#_editMissingFirstNameError").html('');
    }

    function ChangeEditLastName() {
        $("#_editMissingLastNameError").html('');
    }

    function editAccount(e) {
        $("#editAccountModal").modal('toggle');
        let id = e.split('_')[1];
        let firstname = e.split('_')[2];
        let middlename = e.split('_')[3];
        let lastname = e.split('_')[4];
        let dob = e.split('_')[5];
        let phone2 = e.split('_')[6];
        let country = e.split('_')[7];
        let city = e.split('_')[8];
        let street = e.split('_')[9];
        let state = e.split('_')[10];
        let zipcode = e.split('_')[11];
        let role_id = e.split('_')[12];
        let status = e.split('_')[13];
        let email = e.split('_')[14];
        let phoneone = e.split('_')[15];

        $("#editAccountId").val(id);
        $("#account_firstname").val(firstname);
        $("#account_middlename").val(middlename);
        $("#account_lastName").val(lastname);
        $("#account_dob").val(dob);
        $("#account_phone2").val(phone2);
        $("#accounts_country").val(country);
        $("#account_city").val(city);
        $("#account_street").val(street);
        $("#account_state").val(state);
        $("#account_zipcode").val(zipcode);
        let account_option = '<option value="">Select</option>';
        for (let i = 0; i < roles.length; i++) {
            if (role_id == roles[i]['id']) {
                account_option +=
                    '<option value="' + roles[i]['id'] + '" selected>' + roles[i]['title'] + '</option>';
            } else {
                account_option +=
                    '<option value="' + roles[i]['id'] + '">' + roles[i]['title'] + '</option>';
            }
        }
        $("#account_role").html(account_option);
        $("#account_sta").val(status);
        $("#account_email").val(email);
        $("#account_phone").val(phoneone);
        if (status == 0) {
            $('#account_sta_false').prop('checked', true);
        } else {
            $('#account_sta_true').prop('checked', true);
        }
    }

    $("#Password").click(function () {
        $("#ConfirmPassword").on('keyup', function () {
            let password = $("#Password").val();
            let confirmPassword = $("#ConfirmPassword").val();
            if (password != confirmPassword) {
                $("#CheckPasswordMatch").html("Password does not match !").css("color", "red");
                $("#accountEdit_btn").attr("disabled", true);
            } else {
                $("#CheckPasswordMatch").html("Password match !").css("color", "green");
                $("#accountEdit_btn").attr("disabled", false);
            }
        });

        if (password != confirmPassword) {
            $("#accountEdit_btn").attr("disabled", true);
        }
    });
</script>
@yield('scripts')
