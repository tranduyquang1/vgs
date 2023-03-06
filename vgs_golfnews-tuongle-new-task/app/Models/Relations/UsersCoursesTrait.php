<?php

namespace App\Models\Relations;

use App\Models\old\CoursesModel;
use App\Models\old\UserModel;

trait UsersCoursesTrait
{
    public function courses()
    {
        return $this->belongsTo(CoursesModel::class, 'course_id');
    }

    public function users()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

}