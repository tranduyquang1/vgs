<?php

namespace App\Models\Relations;

use App\Models\old\ClassCoursesOfflineModel;
use App\Models\old\SessionCourseOfflineModel;
use App\Models\old\SessionsCoursesOfflineModel;
use App\Models\old\TeacherCoursesOfflineModel;

trait TeacherCoursesOfflineTrait
{
    public function sessions_courses_offline()
    {
        return $this->hasMany(SessionCourseOfflineModel::class, 'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassCoursesOfflineModel::class, 'teacher_id');
    }

    public function sessionsCoursesOffline()
    {
        return $this->hasMany(SessionsCoursesOfflineModel::class, 'teacher_id')
            ->where('lock', '=', 1);
    }

    public function courses()
    {
        return $this->hasMany(TeacherCoursesOfflineModel::class, 'teacher_id');
    }
}