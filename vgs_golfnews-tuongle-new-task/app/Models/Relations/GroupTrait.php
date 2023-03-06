<?php

namespace App\Models\Relations;

use App\Models\old\UserModel;

trait GroupTrait
{
    public function users()
    {
        return $this->hasMany(UserModel::class, 'group_id');
    }
}