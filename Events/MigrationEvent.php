<?php

namespace PRipple\Illuminate\Database\Events;

use Illuminate\Contracts\Database\Events\MigrationEvent as MigrationEventContract;
use PRipple\Illuminate\Database\Migrations\Migration;

abstract class MigrationEvent implements MigrationEventContract
{
    /**
     * A migration instance.
     *
     * @var \PRipple\Illuminate\Database\Migrations\Migration
     */
    public $migration;

    /**
     * The migration method that was called.
     *
     * @var string
     */
    public $method;

    /**
     * Create a new event instance.
     *
     * @param  \PRipple\Illuminate\Database\Migrations\Migration  $migration
     * @param  string  $method
     * @return void
     */
    public function __construct(Migration $migration, $method)
    {
        $this->method = $method;
        $this->migration = $migration;
    }
}
