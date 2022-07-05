<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pay_periods extends Model
{
    protected $fillable = [
        'user_id',
        'startDate',
        'endDate',
        'earning_d',
        'earnings',
        'bonus',
        'hours',
        'hoursPrice',
        'grossIncome',
        'tax',
        'taxAmount',
        'draw_balance',
        'net_income',
        'submitted_at',
        'approve_status',
        'approved_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}