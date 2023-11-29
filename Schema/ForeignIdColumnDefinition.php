<?php

namespace PRipple\Illuminate\Database\Schema;

use Illuminate\Support\Str;

class ForeignIdColumnDefinition extends ColumnDefinition
{
    /**
     * The schema builder blueprint instance.
     *
     * @var \PRipple\Illuminate\Database\Schema\Blueprint
     */
    protected $blueprint;

    /**
     * Create a new foreign ID column definition.
     *
     * @param  \PRipple\Illuminate\Database\Schema\Blueprint  $blueprint
     * @param  array  $attributes
     * @return void
     */
    public function __construct(Blueprint $blueprint, $attributes = [])
    {
        parent::__construct($attributes);

        $this->blueprint = $blueprint;
    }

    /**
     * Create a foreign key constraint on this column referencing the "id" column of the conventionally related table.
     *
     * @param  string|null  $table
     * @param  string|null  $column
     * @param  string|null  $indexName
     * @return \PRipple\Illuminate\Database\Schema\ForeignKeyDefinition
     */
    public function constrained($table = null, $column = 'id', $indexName = null)
    {
        return $this->references($column, $indexName)->on($table ?? Str::of($this->name)->beforeLast('_'.$column)->plural());
    }

    /**
     * Specify which column this foreign ID references on another table.
     *
     * @param  string  $column
     * @param  string  $indexName
     * @return \PRipple\Illuminate\Database\Schema\ForeignKeyDefinition
     */
    public function references($column, $indexName = null)
    {
        return $this->blueprint->foreign($this->name, $indexName)->references($column);
    }
}
