<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    protected $guarded = [];

    /**
     * Get the user that owns the Ambulance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }
}
