<?php

namespace App\Models\Relations;

use App\Models\old\AnswerModel;
use App\Models\old\CoursesModel;
use App\Models\old\CoursesOutlinesModel;
use App\Models\old\UserModel;

trait QuestionTrait
{
    public function users()
    {
        return $this->belongsTo(UserModel::class, 'user_question_id');
    }

    public function courses()
    {
        return $this->belongsTo(CoursesModel::class, 'course_id');
    }

    public function coursesVideo()
    {
        return $this->belongsTo(CoursesOutlinesModel::class, 'video_id');
    }

    public function answer()
    {
        return $this->hasOne(AnswerModel::class, 'question_id');
    }
}