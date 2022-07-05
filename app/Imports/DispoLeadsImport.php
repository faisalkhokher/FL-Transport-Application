<?php

namespace App\Imports;

use App\Lead;
use App\HistoryNote;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DispoLeadsImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
       $Products = "";
       $ProductDescription = null;
       $LeadStatus = 3;
       $ConfirmedBy = null;
       $LeadNumber = rand(1000000, 9999999);
       $LeadType = 3;
       $Name = $row['name'];
       $FirstName = "";
       $LastName = "";
       $Phone2 = null;
       $Phone1 = $row['number'];
       $AppointmentTime = null;
       $Status = "";
       $UserId = 1;
       $Email = null;
       $State = null;
       $ZipCode = null;

       // Split name into first name and last name
       $Names = explode(" ", $Name);
       if (array_key_exists(0,$Names)){
         $FirstName = $Names[0];
       }
       if (array_key_exists(1,$Names)){
         $LastName = $Names[1];
       }

       // Set Products
       if ($row['products'] == "W") {
         $Products = 1;
       }
       elseif ($row['products'] == "R") {
         $Products = 2;
       }
       elseif ($row['products'] == "K") {
         $Products = 3;
       }
       elseif ($row['products'] == "B") {
         $Products = 4;
       }
       elseif ($row['products'] == "S") {
         $Products = 5;
       }
       else {
         $Products = 6;
         $ProductDescription = $row['products'];
       }

       // Set Lead Status
       if($row['status'] == 13) {
         $Status = "Lead status is Sale";
       } elseif ($row['status'] == 10) {
         $Status = "Lead status is Demo";
       } elseif ($row['status'] == 9) {
         $Status = "Lead status is 1 Legger";
       } elseif ($row['status'] == 8) {
         $Status = "Lead status is Not Home";
       } elseif ($row['status'] == 6) {
         $Status = "Lead status is No Demo";
       } elseif ($row['status'] == 4) {
         $Status = "Lead status is Not Cover";
       } elseif ($row['status'] == 3) {
         $Status = "Lead status is Reject";
       } elseif ($row['status'] == 2) {
         $Status = "Lead status is Backup";
       } elseif ($row['status'] == 1) {
         $Status = "Lead status is Cancelled";
       }

       // Check Lead Duplication
       $IsDuplicated = $this->CheckLeadIsDuplicated($Phone1);

       // Get duplicated lead Number
       if ($IsDuplicated == 1) {
         $LeadNumber = $this->GetDuplicatedLeadNumber($Phone1);
       }

       // Entry in the History Notes
       $lead_details = DB::table('leads')->max('id');
       if ($lead_details != "") {
         $lead_id = $lead_details;
         $lead_id = $lead_id + 1;
       }
       else {
         $lead_id = 1;
       }

       if ($row['region'] != "") {
         HistoryNote::create([
           'user_id' => 1,
           'lead_id' => $lead_id,
           'history_note' => "Region of the lead is " . $row['region'],
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
         ]);
       }

       if ($Status != "") {
         HistoryNote::create([
           'user_id' => 1,
           'lead_id' => $lead_id,
           'history_note' => $Status,
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
         ]);
       }

       if ($row['comment'] != "") {
         HistoryNote::create([
           'user_id' => 1,
           'lead_id' => $lead_id,
           'history_note' => $row['comment'],
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now()
         ]);
       }

       return new Lead([
          'user_id'      => $UserId,
          'team_id'      => 0,
          'lead_number'  => $LeadNumber,
          'firstname'    => $FirstName,
          'lastname'    => $LastName,
          'phone'        => $Phone1,
          'product'      => $Products,
          'product_desc' => $ProductDescription,
          'lead_type'    => $LeadType,
          'lead_status'  => $LeadStatus,
          'is_duplicated' => $IsDuplicated,
          'created_at'   => Carbon::now(),
          'updated_at'   => Carbon::now(),
       ]);
    }

    public function CheckLeadIsDuplicated($Phone)
    {
        $Check = DB::table('leads')
                 ->whereIn('lead_type', array(1,2,3))
                 ->where('deleted_at', '=', null)
                 ->where(function ($query) use ($Phone) {
                    if($Phone != ""){
                      $query->orWhere('leads.phone', '=', $Phone);
                      $query->orWhere('leads.phone2', '=', $Phone);
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

    public function GetDuplicatedLeadNumber($Phone)
    {
        $Check = DB::table('leads')
               ->whereIn('lead_type', array(1,2,3))
               ->where('deleted_at', '=', null)
               ->where(function ($query) use ($Phone) {
                  if($Phone != ""){
                    $query->orWhere('leads.phone', '=', $Phone);
                    $query->orWhere('leads.phone2', '=', $Phone);
                  }
               })
               ->get();

         return $Check[0]->lead_number;
    }
}
