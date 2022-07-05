<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuissnessAccount extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
