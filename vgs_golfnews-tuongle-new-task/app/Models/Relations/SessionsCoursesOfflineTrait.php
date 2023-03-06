<?php

namespace App\Models\Relations;

use App\Models\old\ClassCoursesOfflineModel;
use App\Models\old\SessionsStudentCoursesOfflineModel;
use App\Models\old\TeacherCoursesOfflineModel;

trait SessionsCoursesOfflineTrait
{
    public function class()
    {
        return $this->belongsTo(ClassCoursesOfflineModel::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(TeacherCoursesOfflineModel::class, 'teacher_id');
    }

    public function sessionsStudent()
    {
        return $this->hasMany(SessionsStudentCoursesOfflineModel::class, 'sessions_id');
    }
}