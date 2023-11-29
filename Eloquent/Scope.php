<?php

namespace Cclilshy\PRipple\Database\Eloquent;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \PRipple\Illuminate\Database\Eloquent\Builder  $builder
     * @param  \PRipple\Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
