<?php

namespace Cclilshy\PRipple\Database;

use Cclilshy\PRipple\Core\Map\CoroutineMap;
use Cclilshy\PRipple\Facade\JsonRpc;
use Cclilshy\PRipple\Database\Proxy\PDOPRoxyPoolMap;
use Cclilshy\PRipple\Facade\RPC;

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
            } elseif ($this->mode === ConnectionHook::MODE_ORIGINAL) {
                return parent::select($query, $bindings, $useReadPdo);
            } else {
                $statement = PDOPRoxyPoolMap::$pools[$this->getName()]->prepare($query);
                $result    = [];
                foreach ($statement->execute($bindings) as $item) {
                    $result[] = $item;
                }
                return $result;
            }
        });
    }
}
