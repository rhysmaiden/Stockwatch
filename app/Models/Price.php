<?php

namespace App\Models;

class Price extends BaseModel
{
    //=== RELATIONSHIPS ===//
    public function houseguest()
    {
        return $this->belongsTo(Houseguest::class);
    }
}
