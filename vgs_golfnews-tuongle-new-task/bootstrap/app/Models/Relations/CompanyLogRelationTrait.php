<?php

namespace App\Models\Relations;

use App\Models\old\UserModel;

trait CompanyLogRelationTrait
{
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}