<?php

namespace App\Models;

use App\Scopes\Scoper;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $scopes
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithScopes($query, $scopes = [])
    {
        return (new Scoper(request()))->apply($query, $scopes);
    }

    /**
     * Get categories belongs to products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
