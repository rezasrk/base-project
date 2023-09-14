<?php

namespace App\Models\Supply;

use App\Models\Traits\Supply\Category\CategoryRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use CategoryRelations;

    protected $guarded = [];
}
