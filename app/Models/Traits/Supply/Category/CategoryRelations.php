<?php

namespace App\Models\Traits\Supply\Category;

use App\Models\Baseinfo;

trait CategoryRelations
{
    public function discipline()
    {
        return $this->belongsTo(Baseinfo::class, 'discipline_id');
    }

    public function unit()
    {
        return $this->belongsTo(Baseinfo::class, 'unit_id');
    }
}
