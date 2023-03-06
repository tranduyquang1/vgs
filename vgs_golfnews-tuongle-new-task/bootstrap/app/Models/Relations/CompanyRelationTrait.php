<?php

namespace App\Models\Relations;

use App\Models\CompanyTransferLogModel;
use App\Models\SheetsModel;
use App\Models\CompanyLogsModel;

trait CompanyRelationTrait
{
    public function logs()
    {
        return $this->hasMany(CompanyLogsModel::class, 'company_id');
    }

    public function sheet()
    {
        return  $this->belongsTo(SheetsModel::class, 'sheets_id');
    }

    public function transferLog()
    {
        return $this->hasMany(CompanyTransferLogModel::class, 'company_id');
    }
}