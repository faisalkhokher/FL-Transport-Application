<?php

namespace App\Imports;

use App\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeadsImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
       $Products = "";
       $ProductDescription = null;
       $LeadStatus = 3;
       $ConfirmedBy = null;
       $LeadNumber = $row['leadnumber'];
       $Phone2 = $row['customercellularphone'];
       $Phone1 = null;
       $time = strtotime($row['leadappointmentdate']);
       $AppointmentTime = date('Y-m-d h:i:s', $time);
       $UserId = 1;
       $Email = null;
       $State = null;
       $ZipCode = str_pad($row['customerzipcode'],5,0,STR_PAD_LEFT);

       // Get state by zipcode
       if ($row['customerzipcode'] != "") {
         $State = $this->GetStateByZipCode($row['customerzipcode']);
       }

       // Set Email
       if ($row['customeremail'] != "")
       {
         $Email = $row['customeremail'];
       }

       // Get UserID
       $UserId = $this->GetUserIdByName($row['leadrepname']);

       // Set Phone 2
       if($row['customerdayphone'] != "") {
         $Phone1 = $row['customerdayphone'];
       }
       elseif ($row['customereveningphone'] != "") {
         $Phone1 = $row['customereveningphone'];
       }

       // Set Products
       if ($row['productname'] == "Windows/Doors") {
         $Products = 1;
       }
       elseif ($row['productname'] == "Roof") {
         $Products = 2;
       }
       elseif ($row['productname'] == "Kitchen") {
         $Products = 3;
       }
       elseif ($row['productname'] == "Bathroom") {
         $Products = 4;
       }
       elseif ($row['productname'] == "Solar") {
         $Products = 5;
       }
       else {
         $Products = 6;
         $ProductDescription = $row['productname'];
       }

       // Set Lead Status
       if ($row['leadstatus'] == "Demo" || $row['leadstatus'] == "No Demo" || $row['leadstatus'] == "1 Legger" || $row['leadstatus'] == "Not home" || $row['leadstatus'] == "Not covered")
       {
         $LeadStatus = 1;
       }
       elseif ($row['leadstatus'] == "Dead lead")
       {
         $LeadStatus = 2;
       }
       elseif ($row['leadstatus'] == "No status")
       {
         $LeadStatus = 3;
       }
       elseif ($row['leadstatus'] == "Sold")
       {
         if ($row['leadsalesstatus'] == "cancelled")
         {
           $LeadStatus = 5;
         }
         elseif ($row['leadsalesstatus'] == "ok")
         {
           $LeadStatus = 4;
         }
       }
       else
       {
         $LeadStatus = 3;
       }

       // Check Lead Duplication
       $IsDuplicated = $this->CheckLeadIsDuplicated($Phone1, $Phone2);

       // Get duplicated lead Number
       if ($IsDuplicated == 1) {
         $LeadNumber = $this->GetDuplicatedLeadNumber($Phone1, $Phone2);
       }

       // Complete Lead Number
       $LeadNumber = str_pad($LeadNumber,7,"0");

       return new Lead([
          'user_id'      => $UserId,
          'team_id'      => 0,
          'lead_number'  => $LeadNumber,
          'firstname'    => $row['customerfirstname'],
          'lastname'     => $row['customerlastname'],
          'phone'        => $Phone1,
          'phone2'       => $Phone2,
          'state'        => $State,
          'city'         => $row['customercity'],
          'street'       => $row['customeraddress'],
          'zipcode'      => $ZipCode,
          'product'      => $Products,
          'product_desc' => $ProductDescription,
          'email'        => $Email,
          'appointment_time' => $AppointmentTime,
          'lead_type'    => 1,
          'lead_status'  => $LeadStatus,
          'is_duplicated' => $IsDuplicated,
          'created_at'   => Carbon::now(),
          'updated_at'   => Carbon::now(),
       ]);
    }

    public function CheckLeadIsDuplicated($Phone, $Phone2)
    {
        $Check = DB::table('leads')
                 ->whereIn('lead_type', array(1,2,3))
                 ->where('deleted_at', '=', null)
                 ->where(function ($query) use ($Phone, $Phone2) {
                    if($Phone != ""){
                      $query->orWhere('leads.phone', '=', $Phone);
                      $query->orWhere('leads.phone2', '=', $Phone);
                    }
                    if($Phone2 != ""){
                      $query->orWhere('leads.phone', '=', $Phone2);
                      $query->orWhere('leads.phone2', '=', $Phone2);
                    }
                 })
                 ->get();

         if(sizeof($Check) > 0) {
           return 1;
         }
         else {
           return 0;
         }
    }

    public function GetDuplicatedLeadNumber($Phone, $Phone2)
    {
        $Check = DB::table('leads')
               ->whereIn('lead_type', array(1,2,3))
               ->where('deleted_at', '=', null)
               ->where(function ($query) use ($Phone, $Phone2) {
                  if($Phone != ""){
                    $query->orWhere('leads.phone', '=', $Phone);
                    $query->orWhere('leads.phone2', '=', $Phone);
                  }
                  if($Phone2 != ""){
                    $query->orWhere('leads.phone', '=', $Phone2);
                    $query->orWhere('leads.phone2', '=', $Phone2);
                  }
               })
               ->get();

         return $Check[0]->lead_number;
    }

    public function GetUserIdByName($Name)
    {
       $UserDetails = DB::table('profiles')->get();
       if (sizeof($UserDetails) > 0) {
         $Status = 0;
         $UserId = 1;
         foreach($UserDetails as $user)
         {
           $fullname = $user->firstname . " " . $user->lastname;
           if ($fullname == $Name) {
             $Status = 1;
             $UserId = $user->user_id;
           }
         }
         if ($Status) {
           return $UserId;
         }
         else {
           return 1;
         }
       }
       else {
         return 1;
       }
    }

    public function GetStateByZipCode($ZipCode)
    {
       $Check = DB::table('zip_code_range')
                ->where('zipmin', '<=', $ZipCode)
                ->where('zipmax', '>=', $ZipCode)
                ->get();

       if (sizeof($Check) > 0) {
         return $Check[0]->name;
       }
       else {
         return null;
       }
    }
}
