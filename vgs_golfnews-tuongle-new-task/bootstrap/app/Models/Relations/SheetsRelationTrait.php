<?php

namespace App\Models\Relations;


use App\Models\FilesModel;
use App\Models\CompanyModel;

trait SheetsRelationTrait
{
    public function company()
    {
        return $this->hasMany(CompanyModel::class, 'sheets_id');
    }

    public function file()
    {
        return $this->belongsTo(FilesModel::class, 'files_id');
    }
}