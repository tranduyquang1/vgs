<?php

namespace App\Models\Relations;

use App\Models\old\CateNewsModel;

trait ArticleRelationTrait
{
    public function category()
    {
        return $this->belongsTo(CateNewsModel::class, 'category_id');
    }
}