<?php

namespace Cclilshy\PRipple\Database\Eloquent\Relations;

use Cclilshy\PRipple\Database\Eloquent\Collection;
use Cclilshy\PRipple\Database\Eloquent\Model;

class MorphMany extends MorphOneOrMany
{
    /**
     * Convert the relationship to a "morph one" relationship.
     *
     * @return \PRipple\Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function one()
    {
        return MorphOne::noConstraints(fn () => new MorphOne(
            $this->getQuery(),
            $this->getParent(),
            $this->morphType,
            $this->foreignKey,
            $this->localKey
        ));
    }

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults()
    {
        return ! is_null($this->getParentKey())
                ? $this->query->get()
                : $this->related->newCollection();
    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param  array  $models
     * @param  string  $relation
     * @return array
     */
    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param  array  $models
     * @param  \PRipple\Illuminate\Database\Eloquent\Collection  $results
     * @param  string  $relation
     * @return array
     */
    public function match(array $models, Collection $results, $relation)
    {
        return $this->matchMany($models, $results, $relation);
    }

    /**
     * Create a new instance of the related model. Allow mass-assignment.
     *
     * @param  array  $attributes
     * @return \PRipple\Illuminate\Database\Eloquent\Model
     */
    public function forceCreate(array $attributes = [])
    {
        $attributes[$this->getMorphType()] = $this->morphClass;

        return parent::forceCreate($attributes);
    }

    /**
     * Create a new instance of the related model with mass assignment without raising model events.
     *
     * @param  array  $attributes
     * @return \PRipple\Illuminate\Database\Eloquent\Model
     */
    public function forceCreateQuietly(array $attributes = [])
    {
        return Model::withoutEvents(fn () => $this->forceCreate($attributes));
    }
}
