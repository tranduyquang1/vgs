<?php

namespace App\Models\Relations;


use App\Models\SheetsModel;

trait FilesRelationTrait
{
    public function sheets()
    {
        return $this->hasMany(SheetsModel::class, 'files_id');
    }
}