<?php

namespace App\Models\Relations;

use App\Models\old\SupportersModel;
use App\Models\old\TagCoursesModel;
use App\Models\old\TeachersModel;

trait CoursesTrait
{

    public function getTeacherAttribute()
    {
        return $this->teachers->first();
    }

    public function getSupporterAttribute()
    {
        return $this->supporters->first();
    }

    public function teachers()
    {
        return $this->belongsToMany(TeachersModel::class, 'courses_object', 'course_id', 'object_id')->where('type', 'teacher')->withPivot('id');
    }

    public function supporters()
    {
        return $this->belongsToMany(SupportersModel::class, 'courses_object', 'course_id', 'object_id')->where('type', 'supporter')->withPivot('id');
    }
}