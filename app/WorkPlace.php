<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkPlace extends Model
{
    protected $guarded = [];

    use SoftDeletes;
}
