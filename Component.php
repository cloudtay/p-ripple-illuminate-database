<?php

namespace PRipple\Illuminate\Database;

use Component\LaravelComponent;
use Illuminate\Container\Container;
use PRipple\Illuminate\Database\Capsule\Manager;
use PRipple\Illuminate\Database\Facade\DB;

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
