<?php

namespace App\Models\Relations;

use App\Models\old\CoursesModel;

trait UsersFilterTrait
{
    public function courses()
    {
        return $this->belongsTo(CoursesModel::class, 'courses_id');
    }
}