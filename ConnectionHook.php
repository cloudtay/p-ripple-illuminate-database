<?php

namespace PRipple\Illuminate\Database;

use Core\Map\CoroutineMap;
use Facade\JsonRpc;
use PRipple\Illuminate\Database\Proxy\PDOPRoxyPoolMap;

class ConnectionHook extends Connection
{
    public const MODE_ORIGINAL = 1;
    public const MODE_PROXY    = 2;
    public int $mode = ConnectionHook::MODE_PROXY;

    /**
     * @param string $query
     * @param array  $bindings
     * @param true   $useReadPdo
     * @return array|mixed
     */
    public function select($query, $bindings = [], $useReadPdo = true): mixed
    {
        return $this->run($query, $bindings, function ($query, $bindings) use ($useReadPdo) {
            if ($this->pretending()) {
                return [];
            }
            if ($this->mode === ConnectionHook::MODE_ORIGINAL) {
                return parent::select($query, $bindings, $useReadPdo);
            } elseif (!CoroutineMap::this()) {
                return parent::select($query, $bindings, $useReadPdo);
            } else {
                return JsonRpc::call(
                    [PDOPRoxyPoolMap::$pools[$this->getName()]->rangeRpc(), 'prepare'],
                    $query, $bindings, []
                );
            }
        });
    }
}
