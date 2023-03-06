<?php

namespace App\Models\Scope;

trait CommonScopeTrait
{
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created', 'desc');
    }
}