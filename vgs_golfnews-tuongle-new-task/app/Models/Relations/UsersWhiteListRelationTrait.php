<?php

namespace App\Models\Relations;

use App\Models\old\UserModel;

trait UsersWhiteListRelationTrait
{
    public function users()
    {
        return $this->belongsTo(UserModel::class, 'users_id');
    }
}