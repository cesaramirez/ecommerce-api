<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Scopes\ParentsScope;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'order'
    ];

    /**
     * Scope a query to only include parents categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParents($query)
    {
        $query->whereNull('parent_id');
    }

    /**
     * Scope a query to order categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query, $direction = 'asc')
    {
        $query->orderBy('order', $direction);
    }

    /**
     * Children categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
