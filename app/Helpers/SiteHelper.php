<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class SiteHelper
{
    public static function settings()
    {
        $Settings = array();
        $Settings['PrimaryColor'] = '#00007B'; // Blue
        return $Settings;
    }

    public static function GetLeadStatus($Status)
    {
        if ($Status == 1) {
            return "Confirm";
        } elseif ($Status == 2) {
            return "Cancelled";
        } elseif ($Status == 3) {
            return "Pending";
        } elseif ($Status == 4) {
            return "Approve Sales";
        } elseif ($Status == 5) {
            return "Bank Turn Down";
        } elseif ($Status == 6) {
            return "Out of Coverage Area";
        } elseif ($Status == 7) {
            return "Not Interested";
        } elseif ($Status == 8) {
            return "Demo";
        } elseif ($Status == 9) {
            return "1 Legger";
        } elseif ($Status == 10) {
            return "Not Home";
        } elseif ($Status == 11) {
            return "Pending Sales";
        } else{
            return '';
        }
    }

    public static function GetLeadStatusColor($lead_status)
    {
        if ($lead_status == 1) {
            return '<span class="badge badge-success">Confirm</span>';
        } elseif ($lead_status == 2) {
            return '<span class="badge badge-danger">Cancelled</span>';
        } elseif ($lead_status == 3) {
            return '<span class="badge badge-warning">Pending</span>';
        } elseif ($lead_status == 4) {
            return '<span class="badge badge-primary">Approve Sales</span>';
        } elseif ($lead_status == 5) {
            return '<span class="badge badge-warning" style="background-color:pink;color:white;">Bank Turn Down</span>';
        } elseif ($lead_status == 6) {
            return '<span class="badge badge-warning" style="background-color:orange;">Out of coverage area</span>';
        } elseif ($lead_status == 7) {
            return '<span class="badge badge-secondary">Not interested</span>';
        } elseif ($lead_status == 8) {
            return '<span class="badge badge-success">Demo</span>';
        } elseif ($lead_status == 9) {
            return '<span class="badge badge-success">1 Legger</span>';
        } elseif ($lead_status == 10) {
            return '<span class="badge badge-success">Not Home</span>';
        } elseif ($lead_status == 11) {
            return '<span class="badge badge-success">Pending Sales</span>';
        }
    }

    static function GetLeadLastNote($LeadId){
        $Note = DB::table('history_notes')
            ->where('lead_id', '=', $LeadId)
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get();
        if(sizeof($Note) > 0){
            return $Note[0]->history_note;
        }
        else{
            return '';
        }
    }
}
