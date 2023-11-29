<?php

namespace PRipple\Illuminate\Database\PDO;

use Doctrine\DBAL\Driver\AbstractPostgreSQLDriver;
use PRipple\Illuminate\Database\PDO\Concerns\ConnectsToDatabase;

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
