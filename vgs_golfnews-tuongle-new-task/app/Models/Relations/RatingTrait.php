<?php

namespace App\Models\Relations;

use App\Models\old\CoursesModel;
use App\Models\old\UserModel;

trait RatingTrait
{
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(CoursesModel::class, 'course_id', 'id');
    }
}