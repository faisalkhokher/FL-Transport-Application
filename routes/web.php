<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

Route::get('clear-cache', function () {
    Artisan::call('storage:link');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    //Create storage link on hosting
    $exitCode = Artisan::call('storage:link', []);
    echo $exitCode; // 0 exit code for no errors.
});

Route::get('/', function () {
    return redirect(url('/login'));
});

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['admin_route_validate']], function () {
    Route::middleware(['auth'])->group(function () {
        /* Admin Routes */
        Route::get('admin/dashboard', 'DashboardController@LoadDashboard')->name('adminDashboard');
        Route::post('admin/ambulances/stored', 'AmbulanceController@AdminStoreAmbulance');
        Route::post('admin/dashboard/ambulances/all', 'AmbulanceController@LoadAmbulances');
        Route::post('admin/delete/ambulance', 'AmbulanceController@Delete');
        Route::post('admin/update/ambulance', 'AmbulanceController@AdminUpdateAmbulance');
        Route::get('ambulance/gmaps', 'AmbulanceController@ambulanceMap');
        Route::get('admin/ambulance/export', 'AmbulanceController@export')->name('ambulance_export');
        //Ambulance Usage
        Route::get('admin/dashboard/ambulance/usage', 'AmbulanceUsageController@index')->name('ambulanceUsage');
        Route::post('admin/ambulance/usage/store', 'AmbulanceUsageController@AdminStoreAmbulanceUsage');
        Route::post('admin/ambulance/usage/all', 'AmbulanceUsageController@LoadAmbulanceUsages');
        Route::post('admin/delete/ambulance/usage', 'AmbulanceUsageController@delete');
        Route::post('admin/update/ambulance/usage', 'AmbulanceUsageController@UpdateAmbulanceUsage');
        Route::get('admin/ambulance/usage/export', 'AmbulanceUsageController@export')->name('ambulanceusage_export');
        // Wheelchair Routes
        Route::get('admin/dashboard/wheelchair', 'WheelChairController@index')->name('wheelchair');
        Route::post('admin/wheelchair/store', 'WheelChairController@AdminStoreWheelchair');
        Route::post('admin/wheelchair/all', 'WheelChairController@LoadWheelchairs');
        Route::post('admin/delete/wheelchair', 'WheelChairController@Delete');
        Route::post('admin/update/wheelchair', 'WheelChairController@AdminUpdateWheelchair');
        Route::get('admin/wheelchair/export', 'WheelChairController@export')->name('wheelchair_export');
        // Projects Routes
        Route::get('admin/dashboard/projects', 'ProjectController@index')->name('projects');
        Route::post('admin/projects/store', 'ProjectController@AdminStoreProjects');
        Route::post('admin/projects/all', 'ProjectController@LoadProjects');
        Route::post('admin/delete/projects', 'ProjectController@Delete');
        Route::post('admin/update/projects', 'ProjectController@AdminUpdateProject');
        Route::get('admin/wheelchair/projects/export', 'ProjectController@export')->name('project_export');
        // prospects
        Route::get('admin/dashboard/prospects', 'ProspectController@index')->name('prospects');
        Route::post('admin/prospects/store', 'ProspectController@AdminStoreProspects');
        Route::post('admin/prospects/all', 'ProspectController@LoadProspects');
        Route::post('admin/delete/prospects', 'ProspectController@Delete');
        Route::post('admin/update/prospects', 'ProspectController@AdminUpdateProspect');
        Route::get('admin/wheelchair/prospects/export', 'ProspectController@export')->name('prospects_export');
        // Field Officers Routes
        Route::get('admin/field-officers', 'FieldOfficerController@ViewFieldOfficers')->name('admin.field-officers');
        Route::get('admin/create/field-officers', 'FieldOfficerController@AddFieldOfficers')->name('add.field-officers');
        Route::post('admin/field-officers/store', 'FieldOfficerController@StoreFieldOfficers')->name('store.field-officers');
        Route::post('admin/field-officer/all', 'FieldOfficerController@LoadFieldOfficers');
        Route::delete('admin/delete/field-officer', 'FieldOfficerController@AdminDeleteFieldOfficers');
        Route::get('admin/edit/field-officer', 'FieldOfficerController@AdminEditFieldOffficers');
        Route::post('admin/field-officer/update', 'FieldOfficerController@AdminUpdateFieldOffficers');
        // Field Sponsors Routes
        Route::get('admin/sponsors', 'SponsorController@ViewSponsors')->name('admin.sponsors');
        Route::get('admin/create/sponsors', 'SponsorController@AddSponsors')->name('add.sponsors');
        Route::post('admin/sponsors/store', 'SponsorController@StoreSponsors')->name('store.sponsors');
        Route::post('admin/sponsors/all', 'SponsorController@LoadSponsors');
        Route::delete('admin/delete/sponsors', 'SponsorController@AdminDeleteSponsorOfficers');
        Route::get('admin/edit/sponsors', 'SponsorController@AdminEditSponsors');
        Route::post('admin/sponsors/update', 'SponsorController@AdminUpdateSponsors');
        // Field Country Routes
        Route::get('admin/countries', 'CountryController@ViewCountries')->name('admin.countries');
        Route::get('admin/create/countries', 'CountryController@AddCountries')->name('add.countries');
        Route::post('admin/countries/store', 'CountryController@StoreCountries')->name('store.countries');
        Route::post('admin/countries/all', 'CountryController@LoadCountries');
        Route::delete('admin/delete/countries', 'CountryController@AdminDeleteCountryOfficers');
        Route::get('admin/edit/countries', 'CountryController@AdminEditSponsors');
        Route::post('admin/countries/update', 'CountryController@AdminUpdateCountries');
        // Field Districts Routes
        Route::get('admin/districts', 'DistrictController@ViewDistrict')->name('admin.districts');
        Route::get('admin/create/districts', 'DistrictController@AddDistrict')->name('add.districts');
        Route::post('admin/districts/store', 'DistrictController@StorDistrict')->name('store.districts');
        Route::post('admin/districts/all', 'DistrictController@LoadDistricts');
        Route::delete('admin/delete/districts', 'DistrictController@AdminDeleteDistricOfficers');
        Route::post('admin/districts/update', 'DistrictController@AdminUpdateDistricts');
        // Field Villages Routes
        Route::get('admin/villages', 'VillageController@ViewVillage')->name('admin.villages');
        Route::get('admin/create/villages', 'VillageController@AddVillage')->name('add.villages');
        Route::post('admin/villages/store', 'VillageController@StoreVillage')->name('store.villages');
        Route::post('admin/villages/all', 'VillageController@LoadVillages');
        Route::delete('admin/delete/villages', 'VillageController@AdminDeleteVillages');
        Route::post('admin/villages/update', 'VillageController@AdminUpdateVillage');
        // Field Workplaces Routes
        Route::get('admin/workplaces', 'WorkPlaceController@ViewWorkplace')->name('admin.workplaces');
        Route::get('admin/create/workplaces', 'WorkPlaceController@AddWorkplace')->name('add.workplaces');
        Route::post('admin/workplaces/store', 'WorkPlaceController@StorWorkplace')->name('store.workplaces');
        Route::post('admin/workplaces/all', 'WorkPlaceController@LoadWorkplaces');
        Route::delete('admin/delete/workplaces', 'WorkPlaceController@AdminDeleteWorkPlaces');
        Route::post('admin/workplaces/update', 'WorkPlaceController@AdminWorkPlaces');
        // Edit Profile Routes
        Route::get('admin/edit-profile', 'UserController@EditProfile');
        Route::post('admin/update-personal-details', 'UserController@UpdatePersonalDetails');
        Route::post('admin/update-account-security', 'UserController@UpdateAccountSecurity');
        // Accounts
        Route::get('admin/accounts', 'AccountController@index')->name('index.accounts');
        Route::get('admin/accounts/add', 'AccountController@add');
        Route::post('admin/accounts/store', 'AccountController@store');
        Route::get('admin/accounts/edit/{Id}', 'AccountController@edit');
        Route::post('admin/accounts/update', 'AccountController@update');
        Route::post('admin/store/accounts', 'AccountController@AdminStoreAmbulance');
        Route::post('admin/accounts/all', 'AccountController@LoadAccounts');
        Route::post('admin/accounts/delete', 'AccountController@delete');
        Route::post('admin/accounts/delete', 'AccountController@delete');
        Route::post('admin/update/accounts', 'AccountController@UpdateAccount');
        /* Admin Routes */
    });
});

Route::group(['middleware' => ['reader_route_validate']], function () {
    Route::middleware(['auth'])->group(function () {
        /* Reader Routes */
        Route::get('reader/dashboard', 'DashboardController@LoadDashboard')->name('readerDashboard');
        // Edit Profile
        Route::get('reader/edit-profile', 'UserController@EditProfile');
        Route::post('reader/update-personal-details', 'UserController@UpdatePersonalDetails');
        Route::post('reader/update-account-security', 'UserController@UpdateAccountSecurity');
        //Field officers
        Route::get('reader/field-officers', 'FieldOfficerController@ViewFieldOfficers')->name('reader.field-officers');
        Route::post('reader/field-officer/all', 'FieldOfficerController@LoadFieldOfficers');
        //Sponsors
        Route::get('reader/sponsors', 'SponsorController@ViewSponsors')->name('reader.sponsors');
        Route::post('reader/sponsors/all', 'SponsorController@LoadSponsors');
        //Country
        Route::get('reader/countries', 'CountryController@ViewCountries')->name('reader.countries');
        Route::post('reader/countries/all', 'CountryController@LoadCountries');
        //Districts
        Route::get('reader/districts', 'DistrictController@ViewDistrict')->name('reader.districts');
        Route::post('reader/districts/all', 'DistrictController@LoadDistricts');
        //Villages
        Route::get('reader/villages', 'VillageController@ViewVillage')->name('reader.villages');
        Route::post('reader/villages/all', 'VillageController@LoadVillages');
        //Workplaces
        Route::get('reader/workplaces', 'WorkPlaceController@ViewWorkplace')->name('reader.workplaces');
        Route::post('reader/workplaces/all', 'WorkPlaceController@LoadWorkplaces');
        //Ambulance
        Route::post('reader/dashboard/ambulances/all', 'AmbulanceController@LoadAmbulances');
        // Ambulance usage
        Route::post('reader/ambulance/usage/all', 'AmbulanceUsageController@LoadAmbulanceUsages');
        // Wheelchair
        Route::post('reader/wheelchair/all', 'WheelChairController@LoadWheelchairs');
        Route::post('reader/projects/all', 'ProjectController@LoadProjects');
        Route::post('reader/prospects/all', 'ProspectController@LoadProspects');
    });
});

Route::middleware(['auth'])->group(function () {
    /* Common Routes */
    Route::get('dashboard', 'DashboardController@index');
    Route::post('/user/all', 'UserController@LoadAdminAllUsers');
    Route::post('/ambulances/all', 'DashboardController@GetAllAmbulances');
    Route::post('/wheelchairs/all', 'DashboardController@GetAllWheelchairs');
    Route::post('/projects/all', 'DashboardController@GetAllProjects');
    Route::post('/prospects/all', 'DashboardController@GetAllProspects');
});
