<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'firstname',
        'middlename',
        'lastname',
        'dob',
        'phone',
        'phone2',
        'country',
        'city',
        'street',
        'state',
        'zipcode',
        'identity1',
        'identity2',
        'profile_picture',
        'document_name',
        'document_numbers',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
