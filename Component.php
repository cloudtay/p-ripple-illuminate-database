<?php

namespace Cclilshy\PRipple\Database;

use Cclilshy\PRipple\Component\LaravelComponent;
use Cclilshy\PRipple\Database\Capsule\Manager;
use Cclilshy\PRipple\Database\Facade\DB;
use Illuminate\Container\Container;

class Component
{
    /**
     * @var Manager $databaseManager
     */
    public static Manager $databaseManager;

    /**
     * @return void
     */
    public static function initialize(): void
    {
        Component::initializeEloquent();
    }

    /**
     * @return void
     */
    public static function initializeEloquent(): void
    {
        Component::$databaseManager = new Manager();
        Component::$databaseManager->setAsGlobal();
        Component::$databaseManager->bootEloquent();
        $container = LaravelComponent::laravel()->container;
        DB::setFacadeApplication($container);
        $container->singleton('db', function (Container $container) {
            return Component::$databaseManager;
        });
    }
}
