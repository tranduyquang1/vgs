<?php

namespace App\Models\Relations;

use App\Models\old\CoursesModel;
use App\Models\old\QuestionModel;
use App\Models\old\SupportersModel;
use App\Models\old\TeachersModel;
use App\Models\old\UsersCoursesModel;

trait CoursesObjectTrait
{
    public function teacher()
    {
        return $this->belongsTo(TeachersModel::class, 'object_id');
    }

    public function supporter()
    {
        return $this->belongsTo(SupportersModel::class, 'object_id');
    }

    public function questions()
    {
        return $this->hasMany(QuestionModel::class, 'course_id', 'course_id');
    }

    public function revenue()
    {
        return $this->hasMany(UsersCoursesModel::class, 'course_id', 'course_id')
            ->where('payment', '<>', 0);
    }

    public function courses()
    {
        return $this->belongsTo(CoursesModel::class, 'course_id');
    }

    public function courses_support()
    {
        return $this->belongsTo(CoursesModel::class, 'course_id')
            ->where('percent_support', '>', 0);
    }
}