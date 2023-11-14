<?php

namespace Illuminate\Database;


use App\PDOProxy\PDOProxyPool;

class ConnectionHook extends Connection
{
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
            return PDOProxyPool::instance()->get()->query($query, $bindings, []);
        });
    }
}
