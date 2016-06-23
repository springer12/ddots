<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{

    const STATE_NEW      = 'new';
    const STATE_RECEIVED = 'received';
    const STATE_REJECTED = 'rejected';
    const STATE_RESERVED = 'reserved';
    const STATE_TESTED   = 'tested';

    /**
     * Scope a query to only include oldest new solution.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOldestNew($query) {
        return $query->where('state', self::STATE_NEW)
            ->orderBy('created_at', 'asc')
            ->firstOrFail();
    }
}
