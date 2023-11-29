<?php

namespace Cclilshy\PRipple\Database\PDO;

use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use Cclilshy\PRipple\Database\PDO\Concerns\ConnectsToDatabase;

class PostgresDriver extends AbstractPostgreSQLDriver
{
    use ConnectsToDatabase;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pdo_pgsql';
    }
}
