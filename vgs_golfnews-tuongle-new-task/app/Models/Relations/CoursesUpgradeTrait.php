<?php

namespace App\Models\Relations;

use App\Models\old\CoursesModel;

trait CoursesUpgradeTrait
{
    public function users()
    {
        return $this->belongsTo(CoursesModel::class, 'courses_id');
    }
}