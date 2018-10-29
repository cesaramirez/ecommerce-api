<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Scoper
{
    /**
     * The request instance.
     */
    protected $request;

    /**
     * Create a new class instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array                                 $scopes
     */
    public function apply(Builder $query, array $scopes)
    {
        foreach ($scopes as $key => $scope) {
            $scope->apply($query, $this->request->get($key));
        }

        return $query;
    }
}
