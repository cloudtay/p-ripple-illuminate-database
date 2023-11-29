<?php

use Cclilshy\PRipple\Component\LaravelComponent;
use Cclilshy\PRipple\Database\Component;
use Cclilshy\PRipple\Database\Facade\DB;
use Cclilshy\PRipple\Database\Proxy\PDOProxyPoolMap;

include __DIR__ . '/vendor/autoload.php';

$kernel = Cclilshy\PRipple\PRipple::configure([]);

LaravelComponent::initialize();
Component::initialize();
PDOProxyPoolMap::initialize();
PDOProxyPoolMap::connect([
    'hostname' => '127.0.0.1',
    'port'     => 3306,
    'username' => 'root',
    'password' => '123456',
    'database' => 'lav',
    'driver'   => 'mysql',
]);

$s = PDOProxyPoolMap::$pools['default']->prepare('SELECT * FROM `user` WHERE `id` = :id');
foreach ($s->execute(['id' => 17]) as $item) {
    var_dump($item);
}

var_dump(DB::table('user')->where('id', 17)->first());
